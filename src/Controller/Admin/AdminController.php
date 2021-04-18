<?php

namespace App\Controller\Admin;

use App\Entity\ContactRequest;
use App\Repository\ContactRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(ContactRequestRepository $repo): Response
    {
        $allEmail = $repo->findByEmail();
        $column = array_column($allEmail, 'email');
        $numberOfEmails = array_count_values($column);
        return $this->render('admin/index.html.twig', [
            'requests' => $numberOfEmails,
        ]);
    }

    /**
     * @Route("/admin/{slug}", name="app_admin_contact")
     */
    public function viewRequest(ContactRequest $contactRequest, ContactRequestRepository $repo)
    {
        $emailContact = $contactRequest->getEmail();
        $request = $repo->findBy(['email' => $contactRequest->getEmail()]);

        return $this->render('admin/view_request.html.twig', [
            'requests' => $request,
            'email_contact' => $emailContact
        ]);
    }

    /**
     * @Route("/admin/request/{id}", name="app_admin_request")
     */
    public function requestFinished(ContactRequest $contactRequest, EntityManagerInterface $manager)
    {
        if ($contactRequest->getIsRequestFinished()){
            $contactRequest->setIsRequestFinished(false);
        }else{
            $contactRequest->setIsRequestFinished(true);
        }

        $manager->persist($contactRequest);
        $manager->flush();

        return $this->redirectToRoute('app_admin_contact', ['slug' => $contactRequest->getSlug()]);

    }
}
