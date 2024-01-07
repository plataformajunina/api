<?php

namespace App\Actions\Users\Support;

use App\Enums\Role;
use App\Events\UserCreated;
use Illuminate\Support\Str;
use App\Models\{Support, User};
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CreateSupport
{
    public function execute(string $role, string $name, string $email): Support
    {
        DB::beginTransaction();
        try {
            $password = app()->environment('testing') ? 'password' : Str::password(10);

            $user = User::query()->create([
                'role' => Role::SUPPORT->value,
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);
            $support = $user->support()->create([
                'role' => $role
            ]);
            DB::commit();

            UserCreated::dispatch($user, $password);

            return $support;
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception(
                message: 'Não foi possível criar o suporte.',
                code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
