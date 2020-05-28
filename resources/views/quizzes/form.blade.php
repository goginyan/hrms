<div class="form-group">
    <label for="title">{{__('Title')}} *</label>
    <input type="text" required name="title" id="title" value="{{$quiz->title??""}}" class="form-control">
</div>
<div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea class="form-control" name="description" rows="5"
              id="description">{{$quiz->description??""}}</textarea>
</div>
<div class="form-group">
    <div class="d-flex justify-content-between align-items-center">
        <label for="employees">{{ __('Attach to Employees') }}</label>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select-all" id="employeesSelectAll">
            <label class="custom-control-label" for="employeesSelectAll">{{__('Select All')}}</label>
        </div>
    </div>
    <select data-width="100%" class="form-control custom-select"
            name="employees[]" multiple
            id="employees">
        @foreach($departments as $department)
            <optgroup class="select2-result-selectable" label="{{$department->name}}">
                @foreach($department->employees as $employee)
                    <option
                        {{isset($quiz)&&$quiz->employees->contains($employee->id)?"selected":""}} value="{{$employee->id}}">{{$employee->fullName}}</option>
                @endforeach
            </optgroup>
        @endforeach
    </select>
</div>
<div class="form-group">
    <div class="d-flex justify-content-between align-items-center">
        <label for="applicants">{{ __('Attach to Pending Applicants') }}</label>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select-all" id="applicantsSelectAll">
            <label class="custom-control-label" for="applicantsSelectAll">{{__('Select All')}}</label>
        </div>
    </div>
    <select data-width="100%" class="form-control custom-select"
            name="applicants[]" multiple
            id="applicants">
        @foreach($applicants as $applicant)
            @continue(!$applicant->email)
            <option {{isset($quiz)&&$quiz->applicants->contains($applicant->id)?"selected":""}}
                    value="{{$applicant->id}}">
                {{$applicant->first_name??'No Name'}} {{$applicant->last_name??''}} ({{$applicant->email}})
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <div class="d-flex justify-content-between align-items-center">
        <label for="questions">{{ __('Include Questions') }}</label>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input select-all" id="questionsSelectAll">
            <label class="custom-control-label" for="questionsSelectAll">{{__('Select All')}}</label>
        </div>
    </div>
    <select data-width="100%" class="form-control custom-select"
            name="questions[]" multiple
            id="questions">
        @foreach($questions as $question)
            <option {{isset($quiz)&&$quiz->questions->contains($question->id)?"selected":""}}
                    value="{{$question->id}}">
                {{$question->title}} <i>({{$questionTypes[$question->type]}})</i>
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="questionsOrdering">{{__('Questions Ordering')}}</label>
    <input type="hidden" name="questions_ordering" id="questions_ordering">
    <ul class="sortable list-group" id="sortedQuestions">
        @isset($quiz)
            @forelse($quiz->questions as $question)
                <li class="list-group-item mb-4" id="{{$question->id}}">{{$question->title}}
                    ({{$questionTypes[$question->type]}})
                </li>
            @empty
            @endforelse
        @endisset
    </ul>
</div>
<div class="custom-control custom-checkbox">
    <input name="active" type="checkbox" {{isset($quiz) && $quiz->active?"checked":""}} value="1"
           class="custom-control-input"
           id="active">
    <label class="custom-control-label" for="active">{{__('Active')}}</label>
</div>