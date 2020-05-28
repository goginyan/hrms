<div class="item-block">
    @can('update departments')
        <a href="{{route('departments.edit',['department'=>$department->id])}}"
           class="list-group-item" title="Edit">{{$department->name}}</a>
    @else
        <span class="list-group-item">{{$department->name}}</span>
    @endcan
    @can('delete departments')
        <form id="destroyDep{{$department->id}}"
              action="{{route('departments.destroy', ['department'=>$department->id])}}"
              method="post">
            @csrf
            @method('delete')
        </form>
        <button title="Remove" type="submit" form="destroyDep{{$department->id}}"
                class="btn btn-sm btn-circle btn-danger destroy-btn">
            <i class="fa fa-times"></i>
        </button>
    @endcan
</div>
@if($department->childrenRecursive->count())
    <div class="list-group list-group-nested">
        @foreach($department->childrenRecursive as $data)
            @include('department.tree', ['department' => $data])
        @endforeach
    </div>
@endif