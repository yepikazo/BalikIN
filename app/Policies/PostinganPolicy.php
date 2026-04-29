<?php

namespace App\Policies;

use App\Models\Postingan;
use App\Models\User;

class PostinganPolicy
{
    /**
     * Admin bisa melakukan semua aksi.
     * Shortcut sebelum method lain diperiksa.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null; // lanjut ke pengecekan method berikutnya
    }

    /**
     * Siapapun yang sudah login bisa melihat daftar postingan.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Siapapun yang sudah login bisa melihat detail postingan.
     */
    public function view(User $user, Postingan $postingan): bool
    {
        return true;
    }

    /**
     * User yang sudah login bisa membuat postingan.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Pelapor hanya bisa edit postingan miliknya sendiri.
     */
    public function update(User $user, Postingan $postingan): bool
    {
        return $user->id === $postingan->id_pelapor;
    }

    /**
     * Pelapor hanya bisa hapus postingan miliknya sendiri.
     */
    public function delete(User $user, Postingan $postingan): bool
    {
        return $user->id === $postingan->id_pelapor;
    }
}
