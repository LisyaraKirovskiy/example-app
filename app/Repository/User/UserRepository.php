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

            $newUser = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'slug' => Str::slug($validated['name']),
            ]);

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
                'slug' => Str::slug($validated['name']),
                'role_id' => $validated['role'],
            ];
            if ($userUpdateRequest->filled('password')) {
                $updateData['password'] = $validated['password'];
            }
            $user->update($updateData);

            $user->phones()->delete();

            foreach ($userUpdateRequest->phones as $phoneData) {
                if (!empty($phoneData['number'])) {
                    $user->phones()->create([
                        'phone_brand_id' => $phoneData['brand_id'],
                        'number' => $phoneData['number']
                    ]);
                }
            }

            if ($userUpdateRequest->hasFile('avatar')) {
                if ($user->avatar) {

                    $pathToFile = $user->created_at->format('Y/m') . '/' . $user->avatar->path;
                    Storage::disk('public')->delete($pathToFile);
                    $user->avatar->delete();
                }
                $folderLevel = $user->created_at->format('Y/m');
                $pathName = $userUpdateRequest->file('avatar')->store($folderLevel, 'public');
                Avatar::query()->create([
                    'path' => last(explode('/', $pathName)),
                    'user_id' => $user->id,
                ]);
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