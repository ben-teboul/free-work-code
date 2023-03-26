<?php

namespace App\Core\Publisher;

use App\Entity\Offer;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface PublisherInterface
{
    public function prepare(Offer $offer): void;
    public function send(Offer $offer): array;
    public function getResponse(ResponseInterface $response): array;

}