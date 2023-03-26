<?php

namespace App\Core\Publisher;

use App\Core\Offer\ContractEnum;
use App\Core\Offer\SectorEnum;
use App\Entity\Offer;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class IndeedPublisher implements PublisherInterface
{
    private array $offerData = [];
    private const URL = 'https://api.indeed.com/v2/jobs';

    public function __construct(private HttpClientInterface $client)
    {
    }

    /**
     * @throws Exception
     */
    public function prepare(Offer $offer): void
    {
        $this->offerData = [
            'title' => $offer->getTitle(),
            'description_offer' => $offer->getDescriptionOffer(),
            'description_profil' => $offer->getDescriptionProfil(),
        ];
        $this->offerData['salary'] = match (true) {
            //On renvoie l'id 1 du site d'annonce pour les salaires entre 0 et 10000 etc ...
            $offer->getSalary() >= 0 && $offer->getSalary() < 20000 => 1,
            $offer->getSalary() >= 20000 && $offer->getSalary() < 40000 => 2,
            $offer->getSalary() >= 40000 && $offer->getSalary() < 60000 => 3,
            $offer->getSalary() >= 60000 && $offer->getSalary() < 80000 => 4,
            $offer->getSalary() >= 80000 && $offer->getSalary() < 100000 => 5,
        };

        $this->offerData['sector'] = match ($offer->getActivitySector()) {
            SectorEnum::AGRICULTURE->value => 'Agriculture',
            SectorEnum::INDUSTRY->value => 'Industry',
            SectorEnum::SERVICES->value => 'Services',
            SectorEnum::TRANSPORT->value => 'Transport',
            SectorEnum::OTHER->value => 'Other',
            default => throw new Exception('Unexpected match value'),
        };

        $this->offerData['contract'] = match ($offer->getContractType()) {
            ContractEnum::CDI->value => 'cdi',
            ContractEnum::CDD->value => 'cdd',
            ContractEnum::INTERIM->value => 'interim',
            ContractEnum::FREELANCE->value => 'freelance',
            ContractEnum::STAGE->value => 'stage',
            ContractEnum::ALTERNANCE->value => 'alternance',
            default => throw new Exception('Unexpected match value'),

        };
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function send(Offer $offer): array
    {
        $this->prepare($offer);
        $response = $this->client->request('POST', self::URL, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($this->offerData),
            ]
        );
        return $this->getResponse($response);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getResponse(ResponseInterface $response): array
    {
        $responseDecode = json_decode($response->getContent(false), true);
        if ($response->getStatusCode() === Response::HTTP_OK) {
            return [
                'status' => 'success',
                'message' => 'Votre offre a bien été publiée sur Indeed'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Votre offre n\'a pas pu être publiée sur Indeed',
                'error' => $responseDecode
            ];
        }
    }
}