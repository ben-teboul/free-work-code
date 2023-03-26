<?php

namespace App\Core\Offer;

enum SectorEnum: string
{
    case AGRICULTURE = 'Agriculture';
    case INDUSTRY = 'Industry';
    case SERVICES = 'Services';
    case TRANSPORT = 'Transport';
    case OTHER = 'Other';
}
