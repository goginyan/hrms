<div class="row">
    @foreach($departments as $department)
        @foreach($department->employees as $employee)
            @if(!$employee->user->role->parent)
                <div class="col text-center">
                    <div class="employee-block border-primary">
                        <p class="m-0">{{$employee->fullName}}</p>
                        <p>{{$employee->role}} - {{$department->name}}</p>
                    </div>
                    @if($employee->subordinates->count())
                        @include('role.employees_tree',['employees'=>$employee->subordinates])
                    @endif
                </div>
            @endif
        @endforeach
        @if($department->children->count())
</div>
<div class="row">
    @include('role.departments_tree', ['departments' => $department->children])
    @endif
    @endforeach
</div>