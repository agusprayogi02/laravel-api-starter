<?php

namespace App\Models;

use App\Enums\Table;
use App\Models\Menu\Menu;
use App\Models\Menu\RoleMenu;
use Carbon\Carbon;
use Fureev\Trees\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property integer id
 * @property string name
 * @property string guard_name
 * @property string institution_id
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Menu|Collection $menus
 */
class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    protected $table = Table::ROLES->value;

    public function menus(): HasManyThrough
    {
        return $this->hasManyThrough(Menu::class,
            RoleMenu::class,
            'role_id',
            'id',
            'id',
            'menu_id',
        );
    }
}
