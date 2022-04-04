<?php
declare(strict_types=1);

namespace Vanmoof\Application\Domain;

enum BikeState: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case ARCHIVED = 'archived';

}
