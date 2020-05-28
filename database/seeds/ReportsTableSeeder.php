<?php

use App\Models\Report;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Report::create([
			'title'        => 'Age Profile',
			'fields'       => [
				'fullName',
				'age',
				'jobTitle',
				'departmentName',
				'citizenship'
			],
			'has_chart'    => true,
			'order_column' => 'age',
		]);
		Report::create([
			'title'        => 'Birthdays',
			'fields'       => [
				'fullName',
				'age',
				'birthdayMonth',
				'dateOfBirth',
				'registration_address',
			],
			'has_chart'    => false,
			'order_column' => 'birthdayMonth',
			'ordering'     => 'desc'
		]);
		Report::create([
			'title'        => 'Employment Status',
			'fields'       => [
				'id',
				'fullName',
				'recruitedAt',
				'status',
			],
			'has_chart'    => true,
			'order_column' => 'status',
		]);
		Report::create([
			'title'        => 'Gender Profile',
			'fields'       => [
				'fullName',
				'sex',
				'jobTitle',
				'departmentName',
				'citizenship'
			],
			'has_chart'    => true,
			'order_column' => 'sex',
		]);
		Report::create([
			'title'        => 'Salary History',
			'fields'       => [
				'id',
				'fullName',
				'recruitedAt',
				'currentSalary',
				'jobTitle',
				'departmentName',
			],
			'has_chart'    => false,
			'order_column' => 'currentSalary',
			'ordering'     => 'desc'
		]);
	}
}
