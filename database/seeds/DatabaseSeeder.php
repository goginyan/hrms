<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	    $this->call(RolesAndPermissionsSeeder::class);
	    $this->call(DepartmentsTableSeeder::class);
	    $this->call(UsersTableSeeder::class);
	    $this->call(SettingsTableSeeder::class);
	    $this->call(DocFieldsTableSeeder::class);
	    $this->call(DocTypesTableSeeder::class);
	    $this->call(ProfileFormFieldsTableSeeder::class);
	    $this->call(ReportsTableSeeder::class);
    }
}
