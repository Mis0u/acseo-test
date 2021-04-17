<?php

namespace App\Controller;

use App\Entity\ContactRequest;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="app_contact")
     */
    public function index(Request $request): Response
    {
        $contactRequest = new ContactRequest();

        $form = $this->createForm(ContactFormType::class, $contactRequest)->handleRequest($request);

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
