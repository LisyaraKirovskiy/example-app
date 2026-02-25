<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\PhoneBrand;
use App\Repository\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {

    }
    public function index(Request $request): View
    {
        $query = User::query()->select(['id', 'name', 'slug', 'email', 'active', 'created_at', 'role_id'])
            ->with('phones:id,phone_brand_id,user_id,number', 'phones.phoneBrand:id,name')
            ->with('avatar:user_id,path')
            ->with('role:id,role')
            ->filter($request);
        return view('users.index', ['users' => $query->paginate(10)->withQueryString()]);
    }
    public function create(): View
    {
        $this->authorize('create-user');
        return view('users.create');
    }


    public function store(UserStoreRequest $userStoreRequest): RedirectResponse
    {
        $this->authorize('create-user');
        $this->userRepository->store($userStoreRequest);
        return redirect()->back()->with('success', 'Пользователь успешно создан');
    }


    public function show(User $user): View
    {
        $videos = $user->videos()->paginate(3);

        return view('users.show', compact('user', 'videos'));
    }


    public function edit(User $user): View
    {
        $this->authorize('update-user', $user);
        $phoneBrands = PhoneBrand::all();
        return view('users.edit', compact('user', 'phoneBrands'));
    }


    public function update(UserUpdateRequest $userUpdateRequest, User $user): RedirectResponse
    {
        $this->authorize('update-user', $user);
        $this->userRepository->update($userUpdateRequest, $user);
        return redirect()->route('users.show', $user)
            ->with('success', 'Данные пользователя обновлены!');
    }


    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete-user', $user);
        $this->userRepository->destroy($user);
        return redirect()->route('users.index')
            ->with('success', "Пользователь '{$user->name}' удален!");
    }
}
