<?php

namespace App\Enums;

use ArchTech\Enums\InvokableCases;

enum Table: string
{
    use InvokableCases;

    case PASSWORD_RESET_TOKENS = 'password_reset_tokens';
    case PERSONAL_ACCESS_TOKENS = 'personal_access_tokens';
    case JOBS = "jobs";
    case FAILED_JOBS = "failed_jobs";
    case MEDIA = "media";
    case USERS = 'users';
    case ROLES = 'roles';
    case PERMISSIONS = 'permissions';
    case MODEL_HAS_PERMISSIONS = 'model_has_permissions';
    case MODEL_HAS_ROLES = 'model_has_roles';
    case ROLE_HAS_PERMISSIONS = 'role_has_permissions';
    case MENUS = 'menus';
    case ROLE_MENUS = 'role_menus';

    // Geo
    case GEO_COUNTRIES = "geo_countries";
    case GEO_PROVINCES = "geo_provinces";
    case GEO_CITIES = "geo_cities";
    case GEO_DISTRICTS = "geo_districts";
    case GEO_SUB_DISTRICTS = "geo_sub_districts";

    // General
    case ABOUT_US = 'about_us';
    case CONTACT_ME = 'contact_me';
    case ADDRESS = 'addresses';
}
