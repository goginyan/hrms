<?php

use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$root                    = new User();
		$root->email             = "root@ro.ot";
		$root->email_verified_at = now();
		$root->password          = bcrypt("root");
		$root->assignRole('root');
		$root->save();

//		ONLY FOR TESTING
		$test                    = new User();
		$test->email             = "test@test.com";
		$test->email_verified_at = now();
		$test->password          = bcrypt("password");
		$test->assignRole('ceo');
		$test->save();
		$emp = $test->employee()->create([
			'first_name' => 'Testing',
			'last_name'  => 'User',
		]);
		$emp->department()->associate(Department::find(1));
		$emp->save();

		$faker = Faker::create();

		$test                    = new User();
		$test->email             = "hr@test.com";
		$test->email_verified_at = now();
		$test->password          = bcrypt("password");
		$test->assignRole('hr');
		$test->save();
		$emp = $test->employee()->create([
			'first_name' => $faker->firstName,
			'last_name'  => $faker->lastName,
		]);
		$emp->department()->associate(Department::find(1));
		$emp->manager()->associate(\App\Models\Employee::find(1));
		$emp->save();

		$test                    = new User();
		$test->email             = "test_hd_2@test.com";
		$test->email_verified_at = now();
		$test->password          = bcrypt("password");
		$test->assignRole('head');
		$test->save();
		$emp = $test->employee()->create([
			'first_name' => $faker->firstName,
			'last_name'  => $faker->lastName,
		]);
		$emp->department()->associate(Department::find(2));
		$emp->manager()->associate(\App\Models\Employee::find(1));
		$emp->save();
		$test                    = new User();
		$test->email             = "test_hd_3@test.com";
		$test->email_verified_at = now();
		$test->password          = bcrypt("password");
		$test->assignRole('head');
		$test->save();
		$emp = $test->employee()->create([
			'first_name' => $faker->firstName,
			'last_name'  => $faker->lastName,
		]);
		$emp->department()->associate(Department::find(3));
		$emp->manager()->associate(\App\Models\Employee::find(1));
		$emp->save();
		$test                    = new User();
		$test->email             = "test_hd_4@test.com";
		$test->email_verified_at = now();
		$test->password          = bcrypt("password");
		$test->assignRole('head');
		$test->save();
		$emp = $test->employee()->create([
			'first_name' => $faker->firstName,
			'last_name'  => $faker->lastName,
		]);
		$emp->department()->associate(Department::find(4));
		$emp->manager()->associate(\App\Models\Employee::find(1));
		$emp->save();
		$test                    = new User();
		$test->email             = "test_hd_5@test.com";
		$test->email_verified_at = now();
		$test->password          = bcrypt("password");
		$test->assignRole('head');
		$test->save();
		$emp = $test->employee()->create([
			'first_name' => $faker->firstName,
			'last_name'  => $faker->lastName,
		]);
		$emp->department()->associate(Department::find(5));
		$emp->manager()->associate(\App\Models\Employee::find(1));
		$emp->save();
		foreach ( range(1, 5) as $i ) {
			$test                    = new User();
			$test->email             = "test_tl_$i@test.com";
			$test->email_verified_at = now();
			$test->password          = bcrypt("password");
			$test->assignRole('manager');
			$test->save();
			$emp = $test->employee()->create([
				'first_name' => $faker->firstName,
				'last_name'  => $faker->lastName,
			]);
			$dep = rand(2, 5);
			$emp->department()->associate(Department::find($dep));
			$emp->manager()->associate(\App\Models\Employee::find($dep + 1));
			$emp->save();
		}
		foreach ( range(1, 10) as $i ) {
			$test                    = new User();
			$test->email             = "test_emp_$i@test.com";
			$test->email_verified_at = now();
			$test->password          = bcrypt("password");
			$test->assignRole('employee');
			$test->save();
			$emp = $test->employee()->create([
				'first_name' => $faker->firstName,
				'last_name'  => $faker->lastName,
			]);
			$dep = rand(2, 5);
			$emp->department()->associate(Department::find($dep));
			$emp->manager()->associate(\App\Models\Employee::find($dep + 5));
			$emp->save();
		}
//		END ONLY FOR TESTING
	}
}
