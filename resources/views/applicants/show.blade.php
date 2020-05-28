@extends('layouts.dashboard')

@section('title',($applicant->first_name??__('No name')).' '.($applicant->last_name??'').' - '.__('Vacancy Applicant'))

@section('content')
    <ul class="list-group list-group-flush applicants-list mt-2">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Email')}}:</span>
            <span class="badge badge-primary badge-lg">
                <a class="text-light" href="mailto:{{$applicant->email}}" target="_blank">{{$applicant->email}}</a>
            </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('First Name')}}:</span>
            <span class="badge badge-primary badge-lg">{{$applicant->first_name}}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>{{__('Last Name')}}:</span>
            <span class="badge badge-primary badge-lg">{{$applicant->last_name}}</span>
        </li>
        @if ($applicant->patronymic)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Patronymic') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->patronymic}}</span>
            </li>
        @endif
        @if ($applicant->photo)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Photo') }}</span>
                <a href="{{$applicant->photo}}" target="_blank">
                    <img src="{{$applicant->photo}}" alt="Applicant Photo" class="img-applicant rounded-circle">
                </a>
            </li>
        @endif
        @if ($applicant->sex)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Sex') }}</span>
                <span class="badge badge-primary badge-lg">{{__($sexes[$applicant->sex])}}</span>
            </li>
        @endif
        @if ($applicant->family_status)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Family Status') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->family_status}}</span>
            </li>
        @endif
        @if ($applicant->nationality)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Nationality') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->nationality}}</span>
            </li>
        @endif
        @if ($applicant->phone)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Phone') }}</span>
                <span class="badge badge-primary badge-lg">
                    <a class="text-light" target="_blank" href="tel:{{$applicant->phone}}">{{$applicant->phone}}</a>
                </span>
            </li>
        @endif
        @if ($applicant->address)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Address') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->address}}</span>
            </li>
        @endif
        @if ($applicant->education)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Education') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->education}}</span>
            </li>
        @endif
        @if ($applicant->work_experience)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Work Experience') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->work_experience}}</span>
            </li>
        @endif
        @if ($applicant->achievements)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Achievements') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->achievements}}</span>
            </li>
        @endif
        @if ($applicant->certificates)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Certificates') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->certificates}}</span>
            </li>
        @endif
        @if ($applicant->skills)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Skills') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->skills}}</span>
            </li>
        @endif
        @if ($applicant->languages)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Languages') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->languages}}</span>
            </li>
        @endif
        @if ($applicant->interests)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Interests') }}</span>
                <span class="badge badge-primary badge-lg">{{$applicant->interests}}</span>
            </li>
        @endif
        @if ($applicant->attach_cv)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Attached CV') }}</span>
                <span class="badge badge-primary badge-lg">
                    <a href="{{$applicant->attach_cv}}" target="_blank" class="text-light">{{__('Open')}}</a>
                </span>
            </li>
        @endif
        @if ($applicant->cover_letter)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('Cover Letter') }}</span>
                <span class="badge badge-primary badge-lg">
                    <a href="{{$applicant->cover_letter}}" target="_blank" class="text-light">{{__('Open')}}</a>
                </span>
            </li>
        @endif
        @if ($applicant->linked_in)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>{{ __('LinkedIn Profile') }}</span>
                <span class="badge badge-primary badge-lg">
                    <a href="{{$applicant->linked_in}}" target="_blank" class="text-light">{{__('View')}}</a>
                </span>
            </li>
        @endif
    </ul>
    <div class="d-flex justify-content-between align-items-center mt-4">
        @can('manage interviews')
            <a href="{{route('applicants.index')}}" class="btn btn-outline-primary">{{__('Back to List')}}</a>
            <form id="destroyApplicant" class="d-none"
                  action="{{route('applicants.destroy', $applicant)}}"
                  method="post">
                @csrf
                @method('delete')
            </form>
            <button type="submit" form="destroyApplicant"
                    class="btn btn-danger">
                {{__('Remove Applicant')}}
            </button>
            <a href="{{route('applicants.edit', $applicant)}}"
               class="btn btn-primary">{{__('Edit Applicant')}}</a>
        @else
            <a href="{{route('dashboard')}}" class="btn btn-outline-primary">{{__('Back to Dashboard')}}</a>
        @endcan
    </div>
@endsection