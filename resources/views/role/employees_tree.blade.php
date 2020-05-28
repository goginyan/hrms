<div class="d-flex flex-wrap justify-content-center mx-2">
    @foreach($employees as $employee)
        <div class="d-flex align-items-center flex-column text-center mx-2 my-2">
            <div class="employee-block" data-toggle="tooltip"
                 title="{{$employee->role}} ({{$employee->department->name}})">
                <img class="profile-picture-sm rounded-circle" alt="avatar"
                     src="{{$employee->avatar??asset('images/no_avatar.jpg')}}">
                <p class="m-0">{{$employee->first_name[0]}}.{{$employee->last_name}}</p>
            </div>
            @if($employee->subordinates->count())
                @include('role.employees_tree',['employees'=>$employee->subordinates])
            @endif
        </div>
    @endforeach
</div>