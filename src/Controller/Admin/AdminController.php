<?php

namespace App\Controller\Admin;

use App\Repository\ContactRequestRepository;
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
}
