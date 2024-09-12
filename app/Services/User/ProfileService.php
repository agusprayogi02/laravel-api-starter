<?php

namespace App\Services\User;
use App\Contracts\Abstracts\BaseService;
use App\Exceptions\RestfulApiException;
use App\Models\Menu\Menu;
use App\Models\User;
use App\Repositories\MenuRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProfileService extends BaseService
{
    protected MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getProfileData(): Model|Collection|Builder|array|null
    {
        return User::query()
            ->find(auth()->id());
    }

    /**
     * @throws RestfulApiException
     */
    public function getProfileMenu(User $user): array
    {
        return $this->menuRepository->getAllMenuByRole($user->roles->pluck('id'));
    }
}
