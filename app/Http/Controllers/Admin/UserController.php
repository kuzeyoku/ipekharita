<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends BaseAdminController
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(): View
    {
        $users = $this->userService->getPaginated(10);
        return $this->renderView('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return $this->renderView('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->redirectSuccess('admin.users.index', 'Yönetici kullanıcısı başarıyla oluşturuldu.');
    }

    public function edit(User $user): View
    {
        return $this->renderView('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $this->userService->update($user, $data);

        return $this->redirectSuccess('admin.users.index', 'Kullanıcı bilgileri başarıyla güncellendi.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kendi hesabınızı silemezsiniz!');
        }

        $this->userService->delete($user);
        return $this->redirectSuccess('admin.users.index', 'Kullanıcı hesabı silindi.');
    }
}
