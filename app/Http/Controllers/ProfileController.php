<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Employee;
use App\Models\ProfileFormField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Rinvex\Country\CountryLoader;

class ProfileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('profile.show')->with([
            'employee' => Auth::user()->employee,
            'fields'   => ProfileFormField::whereActive(true)->get(),
            'degrees'  => Education::$degrees
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('profile.edit')->with([
            'employee'  => Auth::user()->employee,
            'fields'    => ProfileFormField::whereActive(true)->with('type')->get(),
            'sexes'     => Employee::$sexes,
            'statuses'  => Employee::$statuses,
            'countries' => countries(true),
            'degrees'   => Education::$degrees
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     */
    public function update(Request $request)
    {
        $employee = Auth::user()->employee;
        $employee->update($request->all());
        if ($request->email && $request->email !== $employee->email) {
            Auth::user()->email = $request->email;
            Auth::user()->save();
            Auth::user()->sendEmailVerificationNotification();
        }
        $customFields = ProfileFormField::where('column', null)->whereActive(true)->get();
        $employee->profileFormFields()->detach();
        foreach ($customFields as $field) {
            $employee->profileFormFields()->attach($field->id, [
                'data' => $request->get($field->form_name)
            ]);
        }
        $educations = $request->only([
            'education_name',
            'education_department',
            'education_specialization',
            'education_degree',
            'education_from',
            'education_to'
        ]);
        if (!empty($educations)) {
            foreach ($employee->educations as $edu) {
                $edu->delete();
            }
            foreach ($educations['education_name'] as $index => $name) {
                $employee->educations()->create([
                    'name'           => $name,
                    'degree'         => !empty($educations['education_degree'][$index]) ? $educations['education_degree'][$index] : null,
                    'department'     => !empty($educations['education_department'][$index]) ? $educations['education_department'][$index] : null,
                    'specialization' => $educations['education_specialization'][$index],
                    'date_from'      => $educations['education_from'][$index],
                    'date_to'        => !empty($educations['education_to'][$index]) ? $educations['education_to'][$index] : null,
                ]);
            }
        }
        $experiences = $request->only([
            'experience_name',
            'experience_position',
            'experience_description',
            'experience_from',
            'experience_to'
        ]);
        if (!empty($experiences)) {
            foreach ($employee->experiences as $exp) {
                $exp->delete();
            }
            foreach ($experiences['experience_name'] as $index => $name) {
                $employee->experiences()->create([
                    'name'        => $name,
                    'position'    => !empty($experiences['experience_position'][$index]) ? $experiences['experience_position'][$index] : null,
                    'description' => $experiences['experience_description'][$index],
                    'date_from'   => $experiences['experience_from'][$index],
                    'date_to'     => !empty($experiences['experience_to'][$index]) ? $experiences['experience_to'][$index] : null,
                ]);
            }
        }
        $employee->save();

        return redirect()->route('profile.show');
    }

    /**
     * Update employee avatar
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(Request $request)
    {
        $employee = Auth::user()->employee;
        $avatar   = request()->file('avatar');
        if ($avatar) {
            $ext  = $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('public/images/avatars/' . $employee->id, "avatar.$ext");

            $newAvatar        = str_replace('public/', 'storage/', $path);
            $employee->avatar = asset($newAvatar);
            $employee->save();

            return response()->json(['avatar' => $employee->avatar], 200);
        } elseif (request()->newAvatar) {
            $employee->avatar = request()->newAvatar;
            $employee->save();

            return response()->json(['avatar' => $employee->avatar], 201);
        }

        return response()->json(['message' => 'Bad Request'], 400);
    }
}
