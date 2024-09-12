<?php

namespace App\Models\Menu;

use App\Enums\Table;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Role Menus
 *
 * @property string $id
 * @property string $institution_id
 * @property int $role_id
 * @property string $menu_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * */
class RoleMenu extends Model
{
    use HasFactory;

    protected $table = Table::ROLE_MENUS->value;

    protected $fillable = [
        'role_id', 'menu_id'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
