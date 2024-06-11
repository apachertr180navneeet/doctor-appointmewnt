<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'doctor'],
            ['name' => 'patient'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

?>
