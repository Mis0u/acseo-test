<?php

namespace App\Controller;

use App\Entity\ContactRequest;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $contactRequest = new ContactRequest();

        $form = $this->createForm(ContactFormType::class, $contactRequest)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($contactRequest);
            $manager->flush();
            $this->addFlash('success', 'Votre question a bien été envoyée');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
