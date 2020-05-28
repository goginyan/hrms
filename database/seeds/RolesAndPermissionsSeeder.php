<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// Reset cached roles and permissions
		app()[PermissionRegistrar::class]->forgetCachedPermissions();

		// create permissions
		Permission::create(['name' => 'view departments']);
		Permission::create(['name' => 'create departments']);
		Permission::create(['name' => 'update departments']);
		Permission::create(['name' => 'delete departments']);
		Permission::create(['name' => 'view roles']);
		Permission::create(['name' => 'create roles']);
		Permission::create(['name' => 'update roles']);
		Permission::create(['name' => 'delete roles']);
		Permission::create(['name' => 'view doc-types']);
		Permission::create(['name' => 'create doc-types']);
		Permission::create(['name' => 'update doc-types']);
		Permission::create(['name' => 'delete doc-types']);
		Permission::create(['name' => 'view employees']);
		Permission::create(['name' => 'view employee']);
		Permission::create(['name' => 'create employees']);
		Permission::create(['name' => 'update employees']);
		Permission::create(['name' => 'delete employees']);
		Permission::create(['name' => 'manage profile-form']);
		Permission::create(['name' => 'manage interviews']);
		Permission::create(['name' => 'view vacancies']);
		Permission::create(['name' => 'create vacancies']);
		Permission::create(['name' => 'update vacancies']);
		Permission::create(['name' => 'delete vacancies']);
        Permission::create(['name' => 'delete time-offs']);
        Permission::create(['name' => 'approve time-offs']);
        Permission::create(['name' => 'manage settings']);
        Permission::create(['name' => 'create teams']);
        Permission::create(['name' => 'view all tasks']);
        Permission::create(['name' => 'manage blog']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'create surveys']);
        Permission::create(['name' => 'manage quizzes']);
        Permission::create(['name' => 'manage rewards']);

        // create roles and assign created permissions
        $role = Role::create([
            'name'         => 'root',
            'display_name' => 'Super Admin',
            'description'  => 'Super Administrator of the site',
        ]);
        $role->givePermissionTo(Permission::all());

        $director = Role::create([
			'display_name' => 'CEO',
			'name'         => 'ceo'
		])->givePermissionTo([
            'view departments',
            'create departments',
            'update departments',
            'delete departments',
            'view employees',
            'view employee',
            'create employees',
            'update employees',
            'delete employees',
            'manage settings',
            'create teams',
            'view all tasks',
            'view reports',
            'manage quizzes',
            'manage rewards',
        ]);

		$director->children()->create([
			'display_name' => 'Human Resources Manager',
			'name'         => 'hr',
		])->givePermissionTo([
            'view departments',
            'update departments',
            'view roles',
            'update roles',
            'view doc-types',
            'create doc-types',
            'update doc-types',
            'delete doc-types',
            'view employees',
            'view employee',
            'update employees',
            'view vacancies',
            'create vacancies',
            'update vacancies',
            'delete vacancies',
            'manage interviews',
            'manage profile-form',
            'create teams',
            'view all tasks',
            'delete time-offs',
            'approve time-offs',
            'manage blog',
            'create posts',
            'create surveys',
            'manage quizzes',
            'manage rewards',
        ]);

		//Testing
		Role::insert([
			[
				'display_name' => 'Head of Department',
				'name'         => 'head',
				'parent_id'    => 2,
				'guard_name'   => config('auth.defaults.guard')
			],
			[
				'display_name' => 'Team Lead',
				'name'         => 'manager',
				'parent_id'    => 4,
				'guard_name'   => config('auth.defaults.guard')
			],
			[
				'display_name' => 'Employee',
				'name'         => 'employee',
				'parent_id'    => 5,
				'guard_name'   => config('auth.defaults.guard')
			]
		]);
	}
}
