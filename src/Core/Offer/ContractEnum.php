<?php

namespace App\Core\Offer;

enum ContractEnum: string
{

    case CDI = 'CDI';
    case CDD = 'CDD';
    case INTERIM = 'Interim';
    case FREELANCE = 'Freelance';
    case STAGE = 'Stage';
    case ALTERNANCE = 'Alternance';
}
