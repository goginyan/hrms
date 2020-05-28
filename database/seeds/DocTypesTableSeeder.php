<?php

use App\Models\DocType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocTypesTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		$vacation = User::find(1)->docTypes()->create([
			"name"         => "vacation_letter",
			"display_name" => "Vacation Letter",
		]);
		/** @var DocType $vacation */
		$vacation->fields()->syncWithoutDetaching([
			['doc_field_id' => 1, 'field_name' => 'First Name', 'order' => 1],
			['doc_field_id' => 1, 'field_name' => 'Last Name', 'order' => 2],
			['doc_field_id' => 2, 'field_name' => 'Count of Working Days', 'order' => 3],
			['doc_field_id' => 1, 'field_name' => 'Reason', 'order' => 4],
			['doc_field_id' => 10, 'field_name' => 'Comment', 'order' => 5],
		]);
		$vacation->approveRoles()->sync([
			3 => ['sequence' => 1],
			2 => ['sequence' => 2],
		]);

		$vacation->createRoles()->sync([5, 6]);

		$trip = User::find(1)->docTypes()->create([
			"name"         => "business_trip",
			"display_name" => "Business Trip",
		]);
		/** @var DocType $trip */
		$trip->fields()->syncWithoutDetaching([
			['doc_field_id' => 1, 'field_name' => 'First Name', 'order' => 1],
			['doc_field_id' => 1, 'field_name' => 'Last Name', 'order' => 2],
			['doc_field_id' => 2, 'field_name' => 'Count of Working Days', 'order' => 3],
			['doc_field_id' => 1, 'field_name' => 'Target', 'order' => 4],
			['doc_field_id' => 1, 'field_name' => 'Location', 'order' => 5],
			['doc_field_id' => 10, 'field_name' => 'Comment', 'order' => 6],
		]);
		$trip->approveRoles()->sync([
			2 => ['sequence' => 1],
		]);

		$trip->createRoles()->sync([5, 3]);
	}
}
