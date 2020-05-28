@extends('layouts.dashboard')

@section('title','Job Announcements')

@section('content')
    @can('create vacancies')
        <div class="d-flex justify-content-end align-items-center mb-4">
            <a href="{{route('vacancies.create')}}" class="btn btn-primary">{{__('Add New')}}</a>
        </div>
    @endcan
    @can('view vacancies')
        <ul class="list-group list-group-flush vacancies-list">
            @foreach($vacancies as $vacancy)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @can('update vacancies')
                        <span>
                            <a href="{{route('vacancies.edit', $vacancy)}}">{{$vacancy->position}}</a>
                            <span
                                class="ml-3 badge badge-{{$vacancy->published?"success":"secondary"}} badge-lg">{{$vacancy->published?__("Published"):__("Unpublished")}}</span>
                            @if ($vacancy->with_form)
                                <span class="ml-3 badge badge-primary badge-lg">{{__("With Application Form")}}</span>
                            @endif
                        </span>
                    @else
                        <span>{{$vacancy->position}}
                            <span
                                class="ml-3 badge badge-{{$vacancy->published?"success":"secondary"}} badge-lg">{{$vacancy->published?__("Published"):__("Unpublished")}}</span>
                            @if ($vacancy->with_form)
                                <span class="ml-3 badge badge-primary badge-lg">{{__("With Application Form")}}</span>
                            @endif
                        </span>
                    @endcan
                    @can('delete vacancies')
                        <form id="destroyVacancy{{$vacancy->id}}"
                              action="{{route('vacancies.destroy', $vacancy)}}"
                              method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <button title="Delete Vacancy" type="submit" form="destroyVacancy{{$vacancy->id}}"
                                class="btn btn-sm btn-circle btn-danger destroy-btn mx-4">
                            <i class="fa fa-times"></i>
                        </button>
                    @endcan
                </li>
            @endforeach
        </ul>
    @endcan
@endsection
