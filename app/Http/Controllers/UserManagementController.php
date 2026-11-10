<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar pengguna sistem dengan pencarian, filter role, pengurutan, dan pagination taktil.
     *
     * @param Request $request
     * @return View
     */
    public function displayUserList(Request $request): View
    {
        $searchKeyword = $request->query('search');
        $roleFilter = $request->query('role');
        $sortColumn = $request->query('sort', 'created_at');
        $sortDirection = $request->query('direction', 'desc');

        $users = User::query()
            ->searchUsersByKeyword($searchKeyword)
            ->filterByRole($roleFilter)
            ->sortUserRecords($sortColumn, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'searchKeyword' => $searchKeyword,
            'roleFilter' => $roleFilter,
            'sortColumn' => $sortColumn,
            'sortDirection' => $sortDirection,
        ]);
    }

    /**
     * Menampilkan formulir penambahan pengguna baru ke sistem.
     *
     * @return View
     */
    public function showUserCreationForm(): View
    {
        return view('users.create');
    }

    /**
     * Menyimpan data pengguna baru setelah divalidasi oleh UserStoreRequest.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function storeNewUserRecord(UserStoreRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan ke sistem.');
    }

    /**
     * Menampilkan formulir pengubahan data pengguna.
     *
     * @param User $user
     * @return View
     */
    public function showUserEditingForm(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Memperbarui data pengguna yang ada setelah divalidasi oleh UserUpdateRequest.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function updateExistingUserRecord(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validatedData = $request->validated();

        $updatePayload = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        // Jika password diisi, perbarui password pengguna
        if (!empty($validatedData['password'])) {
            $updatePayload['password'] = Hash::make($validatedData['password']);
        }

        $user->update($updatePayload);

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Menghapus data pengguna dari sistem dengan proteksi penghapusan akun sendiri.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function deleteUserRecord(User $user): RedirectResponse
    {
        // Proteksi: Pengguna tidak boleh menghapus akun yang sedang aktif digunakan login
        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna ' . $userName . ' berhasil dihapus dari sistem.');
    }
}
