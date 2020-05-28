<?php

use App\Models\DocField;
use Illuminate\Database\Seeder;

class DocFieldsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$field          = new DocField();
		$field->name    = "Text Field";
		$field->partial = "text";
		$field->save();

		$field          = new DocField();
		$field->name    = "Number Field";
		$field->partial = "number";
		$field->save();

		$field          = new DocField();
		$field->name    = "Date Field";
		$field->partial = "date";
		$field->save();

		$field          = new DocField();
		$field->name    = "Datetime Field";
		$field->partial = "datetime";
		$field->save();

		$field          = new DocField();
		$field->name    = "Checkbox Field";
		$field->partial = "checkbox";
		$field->save();

		$field          = new DocField();
		$field->name    = "Password Field";
		$field->partial = "password";
		$field->save();

		$field          = new DocField();
		$field->name    = "Telephone Field";
		$field->partial = "tel";
		$field->save();

		$field          = new DocField();
		$field->name    = "Email Field";
		$field->partial = "email";
		$field->save();

		$field          = new DocField();
		$field->name    = "Attachment Field";
		$field->partial = "file";
		$field->save();

		$field          = new DocField();
		$field->name    = "Textarea Field";
		$field->partial = "textarea";
		$field->save();

		$field          = new DocField();
		$field->name    = "Color Field";
		$field->partial = "color";
		$field->save();
	}
}
