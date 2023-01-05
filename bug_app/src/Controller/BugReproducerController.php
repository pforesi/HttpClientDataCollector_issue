<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BugReproducerController extends AbstractController
{
    #[Route('/bug/reproducer', name: 'app_bug_reproducer')]
    public function index(HttpClientInterface $client): StreamedResponse
    {
        $response = new StreamedResponse();
        $response->setCallback(function () use ($client) {
            $response = $client->request('GET', 'https://symfony.com');
            echo $response->getStatusCode();
        });

        return $response;
    }
}
