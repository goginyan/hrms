<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocTypeStoreRequest;
use App\Models\DocField;
use App\Models\DocType;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('doc_types.index')->with([
            'docTypes' => DocType::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('doc_types.add')->with([
            'docFields' => DocField::all(),
            'roles'     => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DocTypeStoreRequest $request
     *
     * @return Response
     */
    public function store(DocTypeStoreRequest $request)
    {
        $docType = Auth::user()->docTypes()->create($request->only(['name', 'display_name']));
        /* @var DocType $docType */
        $fieldsTypes = $request->fields_types;
        $fieldsNames = $request->fields_names;
        foreach ($fieldsTypes as $key => $field) {
            $docType->fields()->attach([
                [
                    'doc_field_id' => $field,
                    'field_name'   => $fieldsNames[$key],
                    'order'        => $key + 1
                ]
            ]);
        }

        foreach ($request->sequence as $i => $s) {
            $docType->approveRoles()->sync([$request->approveRoles[$i] => ['sequence' => $s]], false);
        }
        $docType->createRoles()->sync($request->createRoles);

        return redirect()->route('doc-types.index');
    }

    /**
     * Display the specified resource.
     *
     * @param DocType $docType
     *
     * @return Response
     */
    public function show(DocType $docType)
    {
        return view('doc_types.show')->with([
            'docType' => $docType
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DocType $docType
     *
     * @return Response
     */
    public function edit(DocType $docType)
    {
        return view('doc_types.edit')->with([
            'docFields'   => DocField::all(),
            'docType'     => $docType,
            'roles'       => Role::all(),
            'createRoles' => array_column($docType->createRoles->toArray(), 'id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DocTypeStoreRequest $request
     * @param DocType             $docType
     *
     * @return Response
     */
    public function update(DocTypeStoreRequest $request, DocType $docType)
    {
        $docType->update($request->only(['name', 'display_name']));
        $fieldsTypes = $request->fields_types;
        $fieldsNames = $request->fields_names;
        $docType->fields()->detach();
        for ($i = 0; $i < count($fieldsTypes); $i++) {
            $docType->fields()->attach([
                [
                    'doc_field_id' => $fieldsTypes[$i],
                    'field_name'   => $fieldsNames[$i],
                    'order'        => $i + 1
                ]
            ]);
        }
        $docType->approveRoles()->detach();
        foreach ($request->sequence as $i => $s) {
            $docType->approveRoles()->attach([$request->approveRoles[$i] => ['sequence' => $s]]);
        }
        $docType->createRoles()->sync($request->createRoles);

        return redirect()->route('doc-types.show', ['docType' => $docType->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DocType $docType
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(DocType $docType)
    {
        $docType->delete();

        return redirect()->route('doc-types.index');
    }
}
