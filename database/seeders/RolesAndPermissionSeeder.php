<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Membuat roles
        $roles = ['admin', 'teacher', 'student'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Membuat permissions
        $permissions = ['read-profile', 'create-student', 'create-hafalan','update-student','delete-student'];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Menambahkan permissions ke roles
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->syncPermissions($permissions);

        $teacherRole = Role::where('name','teacher')->first();
        $teacherRole->syncPermissions($permission);

        $studentRole = Role::where('name','student')->first();
        $teacherRole->syncPermissions(['read-profile']);

        // Membuat user admin
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'father_name' => 'German',
            'mother_name' => 'Alicia',
            'alamat' => 'Ring Road',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '1992-11-22',
        ]);
        $admin->assignRole('admin');

        // Membuat user teacher
        $teacher = User::create([
            'name' => 'Teacher',
            'username' => 'teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'father_name' => 'Alex',
            'mother_name' => 'Alexia',
            'alamat' => 'Ring Road',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2001-01-01',
        ]);
        $teacher->assignRole('teacher');

        // Membuat user student
        $student = User::create([
            'name' => 'Student',
            'username' => 'student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'father_name' => 'Xyberus',
            'mother_name' => 'Veriale',
            'alamat' => 'Ring Road',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2001-02-02',
        ]);
        $student->assignRole('student');

    }
}
