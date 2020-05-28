<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsStoreRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Edit the specified resource in storage.
     *
     * @return Response
     */
    public function edit()
    {
        return view('setting.edit')->with([
            'setting' => Setting::find(1),
            'admin' => User::find(1)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingsStoreRequest $request
     * @param Setting              $setting
     *
     * @return Response
     */
    public function update(SettingsStoreRequest $request, Setting $setting)
    {
        $logo = $request->file('company_logo');
        if ($logo) {
            $ext  = $logo->getClientOriginalExtension();
            $path = $logo->storeAs('public/images', "company_logo.$ext");

            $company_logo          = str_replace('public/', 'storage/', $path);
            $setting->company_logo = asset($company_logo);
        }
        $setting->company_name = $request->company_name;
        $setting->language     = $request->language;
        $setting->timezone     = $request->timezone;
        $setting->mail_from    = $request->mail_from;
        $setting->mail_name    = $request->mail_name;
        $setting->save();
        if (empty($request->password)) {
            $request->request->remove('password');
        }
        Auth::user()->update($request->all());

        return redirect()->home();
    }

}
