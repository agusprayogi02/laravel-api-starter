<?php

namespace App\Enums;

use App\Enums\MetaProperties\Description;
use App\Enums\MetaProperties\FeatureGroup;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Meta\Meta;
use ArchTech\Enums\Metadata;
use ArchTech\Enums\Values;

#[Meta(Description::class, FeatureGroup::class)]
enum Permission: string
{
    use InvokableCases, Values, Metadata;

//    Permissions
    #[Description("can show all data permissions")] #[FeatureGroup("permissions")]
    case PERMISSIONS_INDEX = "permissions.index";


    //    Roles
    #[Description("can show all data roles")] #[FeatureGroup("roles")]
    case ROLES_INDEX = "roles.index";
    #[Description("can show data roles by id")] #[FeatureGroup("roles")]
    case ROLES_SHOW = "roles.show";
    #[Description("can add new data roles")] #[FeatureGroup("roles")]
    case ROLES_STORE = "roles.store.institution";
    #[Description("can update data roles by id")] #[FeatureGroup("roles")]
    case ROLES_UPDATE = "roles.update";
    #[Description("can delete data roles by id")] #[FeatureGroup("roles")]
    case ROLES_DESTROY = "roles.destroy";
    #[Description("can sync data roles and permission")] #[FeatureGroup("roles")]
    case ROLES_SYNC_PERMISSIONS = "roles.sync.permissions";

    #[Description("can sync data user and roles")] #[FeatureGroup("users")]
    case USERS_SYNC_ROLES = "users.sync.roles";

    //    Periods
    #[Description("can show all data periods")] #[FeatureGroup("periods")]
    case PERIODS_INDEX = "periods.index";
}
