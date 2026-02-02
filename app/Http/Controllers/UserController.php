<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Contracts\View\View;
class UserController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('created_at')->paginate(10);
        return view('users.index', ['users' => $users]);
    }
    public function create()
    {
        return view('users.create');
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $newUser = new User();
        $newUser->name = $validated['name'];
        $newUser->email = $validated['email'];
        $newUser->password = $validated['password'];
        $newUser->save();
        return redirect()->back()->with('success', 'Пользователь успешно создан');


    }


    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        if ($request->filled('password')) {
            $updateData['password'] = $validated['password'];
        }
        $user->update($updateData);
        return redirect()->route('users.show', $user)
            ->with('success', 'Данные пользователя обновлены!');
    }


    public function destroy(User $user): RedirectResponse
    {
        $user->delete($user->id);
        $users = User::orderBy('created_at')->paginate(10);
        return redirect()->route('users.index')
            ->with('success', "Пользователь '{$user->name}' удален!")
            ->with('info', 'Данные удалены безвозвратно');
    }
}
