<?php

namespace App\Enums\Media;

use ArchTech\Enums\InvokableCases;

enum MediaCollection: string
{
    use InvokableCases;

    case BANNERS = 'banners';
    case BRANCH_OFFICES = 'branch_offices';
    case TUTORIALS = 'tutorials';
    case TEMPLATE_DOCUMENTS = 'template_documents';
}
