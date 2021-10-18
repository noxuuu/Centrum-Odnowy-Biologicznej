<?php
/**
 * Created by PhpStorm.
 * Project: centrumodnowybiologicznej
 * User: Patryk Szczepański
 * Date: 13/10/2021
 * Time: 21:49
 */

namespace App\Controller\admin\album;

use App\Entity\Album;
use App\Entity\Photo;
use App\Form\AlbumType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class albumController extends AbstractController
{
    /**
     * Get common of albums
     * @Route("/adminpanel/album", name="adminAlbums")
     */
    public function categories(Request $request)
    {
        // get repos
        $albumsRepo = $this->getDoctrine()->getRepository(Album::class);
        $photosRepo = $this->getDoctrine()->getRepository(Photo::class);

        // create and handle form
        $album = new Album();
        $entityManager = $this->getDoctrine()->getManager();

        $form_add = $this->createForm(AlbumType::class, $album);
        $form_add->handleRequest($request);

        // === Perform data ===
        if ($form_add->isSubmitted() && $form_add->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();

            $this->addFlash('add_success', 'Utworzono album '.$album->getName().'!');

            return $this->redirectToRoute('adminAlbums');
        }

        // add some breadcrumbs
        $breadcrumbs = [
            ['Panel Administracyjny', '#'],
            ['Albumy na stronie', $this->generateUrl('adminAlbums')]
        ];

        return $this->render('adminpanel/album/index.html.twig', [
            'mainTitle' => 'Centrum odnowy biologicznej',
            'pageTitle' => 'Albumy na stronie',
            'breadcrumbs' => $breadcrumbs,
            'albums' => $albumsRepo->findAll(),
            'photos' => $photosRepo->findAll(),
            'form_add' => $form_add->createView()
        ]);
    }

    /**
     * @Route("/adminpanel/albums/{album}", name="adminAlbumsView")
     * @Entity("Album")
     */
    public function albumView(Request $request, Album $album)
    {
        // get repos
        $albumsRepo = $this->getDoctrine()->getRepository(Album::class);
        $photosRepo = $this->getDoctrine()->getRepository(Photo::class);

        // create and handle form
        $entityManager = $this->getDoctrine()->getManager();

        $form_edit = $this->createForm(albumType::class, $album);
        $form_edit->handleRequest($request);

        // === Perform data ===
        if ($form_edit->isSubmitted() && $form_edit->isValid()) {
            $entityManager->persist($album);
            $entityManager->flush();

            $this->addFlash('edit_success', 'Edytowano album '.$album->getName().'!');
            return $this->redirectToRoute('adminAlbumsView', ['album' => $album->getId()]);
        }

        // render page
        return $this->render('admin/pages/albums/view/index.html.twig', [
            'mainTitle' => 'Katarzyna Kropornicka Fotografia',
            'pageTitle' => 'Albumy',
            'breadcrumbs' => [
                ['Panel Administracyjny', $this->generateUrl('adminDashboard')],
                ['Albumy', $this->generateUrl("adminAlbums")]
            ],
            'albums' => $albumsRepo->findAll(),
            'photos' => $photosRepo->findAllByAlbum($album),
            'selectedAlbum' => $album,
            'form_edit' => $form_edit->createView()
        ]);
    }

    /**
     * @Route("/admin/albums/photo/{id}/delete", name="adminPhotoDelete")
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function deletePhoto(Request $request, $id)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $photo = $this->getDoctrine()->getRepository(Photo::class)->find($id);

            if($photo)
            {
                $filesystem = new Filesystem();
                $filesystem->remove('assets/images/uploads/'.$photo->getName());

                $entityManager->remove($photo);
                $entityManager->flush();

                $data[0] = true;
            }
            else
                $data[0] = false;

        } catch (\Exception $e) {
            $data[0] = false;
        }

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }

    /**
     * @Route("/admin/albums/{name}/delete", name="adminAlbumDelete")
     * @param Request $request
     * @param $name
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAlbum(Request $request, $name)
    {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $album = $this->getDoctrine()->getRepository(Album::class)->find($name);

            if($album) {
                // delete every photo from album
                $photos = $this->getDoctrine()->getRepository(Photo::class)->findBy(['album' => $album]);

                try {
                    // create filesystem
                    $filesystem = new Filesystem();

                    // delete parent photos
                    foreach($photos as $photo) {
                        $filesystem->remove('assets/images/uploads/'.$photo->getName());
                        $entityManager->remove($photo);
                    }

                    // delete album
                    $entityManager->remove($album);
                    $entityManager->flush();

                } catch (\Exception $e) { // catch error and send notification if they exist
                    $data[0] = false;
                }


                $data[0] = true;
            }
            else
                $data[0] = false;

        } catch (\Exception $e) {
            $data[0] = false;
        }

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
            return new JsonResponse($data);
        else
            throw new \Exception('Not allowed usage');
    }
}
