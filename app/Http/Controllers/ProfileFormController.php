<?php

namespace App\Http\Controllers;

use App\Models\DocField;
use App\Models\ProfileFormField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileFormController extends Controller
{

    /**
     * Display all available fields for profile form
     *
     * @return Response
     */
    public function index()
    {
        return view('profile.form.index')->with([
            'fields' => ProfileFormField::with('type')->get(),
            'types' => DocField::all()
        ]);
    }

    /**
     * Store the field
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $field            = ProfileFormField::create($request->all());
        $field->form_name = trim(strtolower(str_replace(' ', '_', $field->label)));
        $field->save();

        return redirect()->route('profile.form.index');
    }

    /**
     * Update the field
     *
     * @param Request          $request
     * @param ProfileFormField $field
     *
     * @return Response
     */
    public function update(Request $request, ProfileFormField $field)
    {
        if (!$field->protected) {
            $field->required = !!$request->required;
            $field->active   = !!$request->active;
            if ($request->label) {
                $field->label = $request->label;
            }
            if ($request->type_id) {
                $field->type()->dissociate();
                $field->type()->associate(DocField::find($request->type_id));
            }
            $field->save();
        }

        return redirect()->route('profile.form.index');
    }

    /**
     * Destroy the field
     *
     * @param ProfileFormField $field
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(ProfileFormField $field)
    {
        if (!$field->column) {
            $field->delete();
        }

        return redirect()->route('profile.form.index');
    }
}
