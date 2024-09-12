<?php

namespace App\Repositories;

use App\Enums\ResponseCode;
use App\Exceptions\RestfulApiException;
use App\Models\Menu\Menu;
use App\Models\Menu\RoleMenu;
use Illuminate\Support\Collection;

class MenuRepository
{
    protected Collection $allMenu;

    public function __construct()
    {
        $this->allMenu = Menu::query()
            ->get();
    }

    /**
     * @throws RestfulApiException
     */
    public function getAllMenu(): array
    {
        $menu = [];
        foreach ($this->allMenu as $value) {
            $menu[] = $value;
        }

        $new = [];
        foreach ($menu as $a) {
            $new[$a['parent_id']][] = $a;
        }

        if (count($menu) == 0) {
            throw new RestfulApiException(ResponseCode::ERR_FORBIDDEN_ACCESS, "You don't have access to any menus");
        }

        return $this->createMenuTree($new, [$menu[0]]);
    }

    protected Collection $getAllParentOfChild;

    /**
     * @throws RestfulApiException
     */
    public function getAllMenuByRole(Collection $selectedRoleId): array
    {
        $this->getAllParentOfChild = collect();

        // Filtering menu where has Multiple Role
        $selectedMenu = RoleMenu::query()
            ->whereIn('role_id', $selectedRoleId)
            ->get()
            ->unique('menu_id');

        foreach ($selectedMenu as $roleMenu) {
            $menu = $this->allMenu->find($roleMenu->menu_id);

            $this->getDescendantFromChild($menu);
        }

        $selectedMenuId = $this->getAllParentOfChild
            ->unique('id')->pluck('id');

        return $this->getAllMenuBySelectedId($selectedMenuId);
    }

    function getDescendantFromChild($category)
    {
        $this->getAllParentOfChild->push($category);

        if ($category->parent_id === null) {
            return $category->name;
        }

        return $this->getDescendantFromChild($this->allMenu->find($category->parent_id));
    }

    /**
     * @throws RestfulApiException
     */
    public function getAllMenuBySelectedId($selectedMenuId): array
    {
        $menu = [];
        foreach ($this->allMenu as $value) {
            if (in_array($value['id'], $selectedMenuId->toArray())) {
                $menu[] = $value;
            }
        }

        $new = [];
        foreach ($menu as $a) {
            $new[$a['parent_id']][] = $a;
        }

        if (count($menu) == 0) {
            throw new RestfulApiException(ResponseCode::ERR_FORBIDDEN_ACCESS, "You don't have access to any menus");
        }

        return $this->createMenuTree($new, [$menu[0]]);
    }

    function createMenuTree(&$list, $parent): array
    {
        $tree = [];
        foreach ($parent as $l) {
            if (isset($list[$l['id']])) {
                $l['children'] = $this->createMenuTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }

        return $tree;
    }
}
