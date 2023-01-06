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
            $url = 'https://symfony.com';
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            echo <<< EOD
            Call to <b>$url</b> done with status: <b>$statusCode</b>
            <p>
            Steps to check the bug: 
            <ol>
            <li>Go to <a href="/_profiler/latest?panel=http_client" target="_blank">web profiler's latest token Http Client panel</a></li>
            <li>Confirm the bug => The panel is empty</li>
            <li>Go to <a href="/_profiler/latest?panel=logger" target="_blank">web profiler's latest token Logs panel</a></li>
            <li>We can see that the request has been successfully done</li>
            </ol>
            EOD;
        });

        return $response;
    }
}
