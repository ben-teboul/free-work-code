<?php

namespace App\Controller;

use App\Core\Offer\ContractEnum;
use App\Core\Offer\SectorEnum;
use App\Core\Publisher\PublisherManager;
use App\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{
    #[Route('/', name: '')]
    #[Route('/job', name: 'app_job')]
    public function index(PublisherManager $publisher): JsonResponse
    {
        $offer = (new Offer())
            ->setTitle('Développeur Symfony')
            ->setDescriptionOffer('Nous recherchons un développeur Symfony pour un poste en CDI')
            ->setDescriptionProfil('Vous avez une expérience de 3 ans minimum en Symfony')
            ->setSalary(60000)
            ->setActivitySector(SectorEnum::SERVICES->value)
            ->setContractType(ContractEnum::CDI->value);

        return $this->json($publisher->send($offer));

    }
}
