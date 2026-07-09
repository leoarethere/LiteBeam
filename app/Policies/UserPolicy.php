<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function view(User $user, User $model): bool
    {
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, User $model): bool
    {
        // Proteksi: User tidak bisa mengedit dirinya sendiri atau admin lain jika tidak memiliki wewenang
        // Karena hanya ada satu flag is_admin, kita pastikan hanya admin yang bisa update.
        if (! $user->is_admin) {
            return false;
        }

        // Tambahkan logika tambahan jika ada Super Admin di masa depan
        return true;
    }

    public function delete(User $user, User $model): bool
    {
        if (! $user->is_admin) {
            return false;
        }

        // Mencegah penghapusan admin lain oleh admin biasa (jika nantinya ada tingkatan)
        // Untuk saat ini, kita izinkan selama user adalah admin.
        return true;
    }
}
