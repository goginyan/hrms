@extends('layouts.dashboard')

@section('title','Edit Role')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('update roles')
                        <form id="roleEditForm" action="{{route('roles.update',['role'=>$role->id])}}" method="post">
                            @csrf
                            @method('put')
                            @include('role.form')
                            <div class="form-group d-flex justify-content-between align-items-center">
                                <a href="{{route('roles.index')}}"
                                   class="btn btn-outline-primary">{{__('Back to List')}}</a>
                                <button class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        let $form = $('#roleEditForm'),
            name = $('#name').val();
        $form.on('submit', function (e) {
            if ($form.find('#name').val() == name) {
                $('#name').attr({
                    name: '',
                    id: ''
                });
            }
        });
    </script>
@endpush