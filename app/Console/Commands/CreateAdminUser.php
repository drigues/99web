<?php

namespace App\Console\Commands;

use App\Models\AdminUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {--email= : Email do administrador}
                            {--password= : Password do administrador}
                            {--name= : Nome do administrador}';

    protected $description = 'Criar ou atualizar um utilizador administrador';

    public function handle(): int
    {
        $email = $this->option('email') ?? $this->ask('Email do administrador', 'admin@99web.pt');
        $password = $this->option('password') ?? $this->secret('Password');
        $name = $this->option('name') ?? $this->ask('Nome', 'Admin');

        if (! $password) {
            $this->error('Password é obrigatória.');

            return self::FAILURE;
        }

        $user = AdminUser::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'super_admin',
            ]
        );

        $this->info($user->wasRecentlyCreated
            ? "Administrador criado: {$email}"
            : "Administrador atualizado: {$email}"
        );

        return self::SUCCESS;
    }
}
