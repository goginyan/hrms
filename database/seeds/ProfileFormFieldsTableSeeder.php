<?php

use App\Models\DocField;
use App\Models\ProfileFormField;
use Illuminate\Database\Seeder;

class ProfileFormFieldsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$field               = new ProfileFormField();
		$field->column       = 'email';
		$field->label        = 'Email';
		$field->form_name    = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->is_protected = true;
		$field->type()->associate(DocField::wherePartial('email')->first());
		$field->save();

		$field               = new ProfileFormField();
		$field->column       = 'first_name';
		$field->label        = 'First Name';
		$field->form_name    = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->is_protected = true;
		$field->save();

		$field               = new ProfileFormField();
		$field->column       = 'last_name';
		$field->label        = 'Last Name';
		$field->form_name    = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->is_protected = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'avatar';
		$field->label     = 'Employee Avatar';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->column)));
		$field->type()->associate(DocField::wherePartial('file')->first());
		$field->is_protected = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'social_in';
		$field->label     = 'LinkedIn Profile';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = true;
		$field->required  = false;
		$field->type()->associate(DocField::wherePartial('text')->first());
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'social_fb';
		$field->label     = 'Facebook Profile';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = true;
		$field->required  = false;
		$field->type()->associate(DocField::wherePartial('text')->first());
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'social_tw';
		$field->label     = 'Twitter Profile';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = true;
		$field->required  = false;
		$field->type()->associate(DocField::wherePartial('text')->first());
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'patronymic';
		$field->label     = 'Patronymic';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'birth_date';
		$field->label     = 'Birth Date';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->type()->associate(DocField::wherePartial('date')->first());
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'sex';
		$field->label     = 'Sex';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'phone_number';
		$field->label     = 'Phone Number';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->type()->associate(DocField::wherePartial('tel')->first());
		$field->save();

		$field               = new ProfileFormField();
		$field->column       = 'status';
		$field->label        = 'Employment Status';
		$field->form_name    = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active       = false;
		$field->required     = true;
		$field->is_protected = true;
		$field->type()->associate(DocField::wherePartial('text')->first());
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'nationality';
		$field->label     = 'Nationality';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'citizenship';
		$field->label     = 'Citizenship';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'residence_address';
		$field->label     = 'Residence Address';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'registration_address';
		$field->label     = 'Registration Address';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'education';
		$field->label     = 'Education';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
		$field->active    = false;
		$field->required  = true;
		$field->type()->associate(DocField::wherePartial('textarea')->first());
		$field->save();

		$field            = new ProfileFormField();
		$field->column    = 'experience';
		$field->label     = 'Work Experience';
		$field->form_name = trim(strtolower(str_replace(' ', '_', $field->column)));
		$field->active    = false;
		$field->required  = true;
		$field->type()->associate(DocField::wherePartial('textarea')->first());
		$field->save();
	}
}
