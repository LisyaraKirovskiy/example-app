<?php
namespace App\Repository\User;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Avatar;
use App\Models\User;
use Exception;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UserRepository implements UserRepositoryInterface
{
    public function store(UserStoreRequest $userStoreRequest): User
    {

        $validated = $userStoreRequest->validated();
        DB::beginTransaction();
        try {

            $newUser = new User();
            $newUser->name = $validated['name'];
            $newUser->email = $validated['email'];
            $newUser->password = Hash::make($validated['password']);
            $newUser->slug = Str::slug($validated['name']);
            $newUser->save();

            //**@var string $folderLevel */
            if ($userStoreRequest->hasFile('avatar')) {
                $folderLevel = $newUser->created_at->format('Y/m');
                $pathName = $userStoreRequest->file('avatar')->store($folderLevel, 'public');

                Avatar::query()->create([
                    'path' => last(explode('/', $pathName)),
                    'user_id' => $newUser->id,
                ]);
            }
            DB::commit();
            return $newUser;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }
    }
    public function update(UserUpdateRequest $userUpdateRequest, User $user): User
    {
        $validated = $userUpdateRequest->validated();
        DB::beginTransaction();
        try {
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            if ($userUpdateRequest->filled('password')) {
                $updateData['password'] = $validated['password'];
            }
            $user->slug = Str::slug($validated['name']);
            $user->update($updateData);
            if ($userUpdateRequest->hasFile('avatar')) {
                if ($user->avatar != null) {
                    if (file_exists($user->avatarPath())) {
                        $user->avatar->delete();
                        $pathToFile = $user->created_at->format('Y/m') . '/' . $user->avatar->path;
                        Storage::disk('public')->delete($pathToFile);

                        $folderLevel = $user->created_at->format('Y/m');
                        $pathName = $userUpdateRequest->file('avatar')->store($folderLevel, 'public');
                        Avatar::query()->create([
                            'path' => last(explode('/', $pathName)),
                            'user_id' => $user->id,
                        ]);
                    }
                } else {
                    $folderLevel = $user->created_at->format('Y/m');
                    $pathName = $userUpdateRequest->file('avatar')->store($folderLevel, 'public');
                    Avatar::query()->create([
                        'path' => last(explode('/', $pathName)),
                        'user_id' => $user->id,
                    ]);
                }
            }
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }

    }
    public function destroy(User $user): User
    {
        DB::beginTransaction();
        try {
            if (file_exists($user->avatarPath())) {
                $user->avatar->delete();
                $pathToFile = $user->created_at->format('Y/m') . '/' . $user->avatar->path;
                Storage::disk('public')->delete($pathToFile);
            }
            $user->delete($user->id);
            DB::commit();
            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical($exception->getMessage());
            throw new BadRequestException($exception->getMessage());
        }
    }
}