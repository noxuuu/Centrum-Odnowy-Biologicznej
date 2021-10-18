<?php
/**
 * Created by PhpStorm.
 * Project: centrumodnowybiologicznej
 * User: Patryk Szczepański
 * Date: 16/10/2021
 * Time: 16:45
 */

namespace App\Controller\admin\album\upload;


use App\Entity\Album;
use App\Entity\Photo;
use App\Service\BackendService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class photoUploadController extends AbstractController
{
    protected $backendService;

    public function __construct(BackendService $backendService)
    {
        $this->backendService = $backendService;
    }

    /**
     * @Route("/image/upload")
     * @param Request $request
     * @param LoggerInterface $logger
     * @return Response
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        // get token
        $token = $request->get("token");

        // validate token
        if (!$this->isCsrfTokenValid('upload', $token))
        {
            $logger->info("CSRF failure");

            return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }

        // get file
        $file = $request->files->get('file');

        // check if file is uploaded propertly
        if (empty($file))
            return new Response("No file specified", Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);

        // get file name
        $filename = $file->getClientOriginalName();

        // get album name
        $albumName = $request->get('album');

        // get albums repo
        $albumsRepo = $this->getDoctrine()->getRepository(Album::class);

        // prepare album object (if not exist - upload directly, without album)
        $album = $albumsRepo->findOneBy(['name' => $albumName]);

        // get entity manager
        $entityManager = $this->getDoctrine()->getManager();

        // prepare our photo
        $photo = new Photo();
        $photo->setAlbum($album);
        $photo->setUploaded(new \DateTime());

        // flush photo object
        $entityManager->persist($photo);
        $entityManager->flush();

        // upload our image to server
        $this->backendService->uploadImage('assets/images/uploads/', $file, $filename);

        // return response 200
        return new Response("File uploaded",  Response::HTTP_OK, ['content-type' => 'text/plain']);
    }
}
