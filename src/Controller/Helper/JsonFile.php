<?php


namespace App\Controller\Helper;

use App\Entity\ContactRequest;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\UuidV4;


class JsonFile
{
    public function create(KernelInterface $kernel,SerializerInterface $serializer, ContactRequest $contactRequest)
    {
        $filesystem = new Filesystem();
        $uuid = UuidV4::v4();
        $projetDir = $kernel->getProjectDir();

        $name = $contactRequest->getName().'-'.$uuid;
        $jsonContent = $serializer->serialize($contactRequest, 'json', ['groups' => 'list_contact']);
        $filesystem->dumpFile("$projetDir/src/Json/$name.json", $jsonContent);
    }
}