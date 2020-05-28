<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$setting               = new Setting();
		$setting->company_name = config('app.name', 'HRMS');
		$setting->company_logo = asset('images/company.png');
		$setting->language     = str_replace('_', '-', app()->getLocale());
		$setting->timezone     = config('app.timezone', 'UTC');
		$setting->mail_from    = config('mail.from.address');
		$setting->mail_name    = $setting->company_name;
		$setting->save();
	}
}
