<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Crea el usuario administrador raiz.
     *
     * Las credenciales salen de ADMIN_EMAIL y ADMIN_PASSWORD, que llegan por
     * variable de entorno. Nunca se escriben fijas en el codigo.
     */
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (! $email || ! $password) {
            $this->command?->warn(
                'Se omite el usuario administrador: faltan ADMIN_EMAIL o ADMIN_PASSWORD en el .env.'
            );

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name'),
                'last_name' => config('admin.last_name'),
                'document_number' => config('admin.document_number'),
                'status' => UserStatus::Activo,
                'email_verified_at' => now(),
                'password' => $password,
            ]
        );

        $this->command?->info('Usuario administrador creado o actualizado.');
    }
}