<?php

namespace App\Controller;

use App\Controller\Helper\JsonFile;
use App\Entity\ContactRequest;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        KernelInterface $kernel,
        JsonFile $jsonFile
    ): Response
    {
        $contactRequest = new ContactRequest();

        $form = $this->createForm(ContactFormType::class, $contactRequest)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($contactRequest);
            $manager->flush();

            $this->addFlash('success', 'Votre question a bien été envoyée');

            $jsonFile->create($kernel,$serializer,$contactRequest);

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
