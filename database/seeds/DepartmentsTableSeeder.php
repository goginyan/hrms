<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$department       = new Department();
		$department->name = 'Top Management';
		$department->save();

		//Testing
		Department::insert([
			[
				'name'        => 'Development',
				'description' => 'Dev Team',
				'parent_id'   => 1
			],
			[
				'name'        => 'Marketing',
				'description' => 'Marketing Team',
				'parent_id'   => 1
			],
			[
				'name'        => 'Support',
				'description' => 'Support Team',
				'parent_id'   => 3
			],
			[
				'name'        => 'SEO',
				'description' => 'SEO Team',
				'parent_id'   => 1
			],
		]);
	}
}
