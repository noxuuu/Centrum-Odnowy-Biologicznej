<?php
/**
 * Created by PhpStorm.
 * Project: centrumodnowybiologicznej
 * User: Patryk Szczepański
 * Date: 16/10/2021
 * Time: 16:44
 */

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BackendService
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        // get logger interface
        $this->logger = $logger;
    }

    /**
     * Uploads an image to server space
     * @param $uploadDir
     * @param $file
     * @param $filename
     */
    public function uploadImage($uploadDir, $file, $filename)
    {
        try {
            $file->move($uploadDir, $filename);
        } catch (FileException $e) {
            $this->logger->error('failed to upload image: ' . $e->getMessage());
            throw new FileException('Failed to upload file');
        }
    }

}
