<?php

namespace App\Models\Menu;

use App\Enums\Table;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Menu
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $level
 * @property string $order
 * @property string $parent_id
 * @property boolean $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Menu $children
 *
 * */
class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = Table::MENUS->value;

    protected $fillable = [
        'name', 'description', 'level', 'order', 'parent_id',
        'icon', 'route', 'created_at', 'updated_at'
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')
            ->with('children')
            ->orderBy('order');
    }
}
