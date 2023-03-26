<?php

namespace App\Core\Publisher;

use App\Entity\Offer;

class PublisherManager
{
    public function __construct(
        private iterable $publishers
    )
    {
    }

    public function send(Offer $offer): array
    {
        $res = [];
        foreach ($this->publishers as $publisher) {
            $res [] = $publisher->send($offer);
        }
        return $res;
    }
}