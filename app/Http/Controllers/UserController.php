<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repository\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Contracts\View\View;
class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {

    }
    public function index(): View
    {
        $users = User::orderBy('created_at')->paginate(10);
        return view('users.index', ['users' => $users]);
    }
    public function create(): View
    {
        return view('users.create');
    }


    public function store(UserStoreRequest $userStoreRequest): RedirectResponse
    {
        $this->userRepository->store($userStoreRequest);
        return redirect()->back()->with('success', 'Пользователь успешно создан');
    }


    public function show(User $user): View
    {
        return view('users.show', ['user' => $user]);
    }


    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }


    public function update(UserUpdateRequest $userUpdateRequest, User $user): RedirectResponse
    {
        $this->userRepository->update($userUpdateRequest, $user);
        return redirect()->route('users.show', $user)
            ->with('success', 'Данные пользователя обновлены!');
    }


    public function destroy(User $user): RedirectResponse
    {
        $this->userRepository->destroy($user);
        return redirect()->route('users.index')
            ->with('success', "Пользователь '{$user->name}' удален!");
    }
}
