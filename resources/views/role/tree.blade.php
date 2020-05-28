<div class="item-block">
    <div class="list-group-item d-flex justify-content-between align-items-center">
        @can('update roles')
            <a href="{{route('roles.edit', $role)}}" data-trigger="hover" data-html="true"
               data-toggle="popover" title="Associated permissions">
                {{$role->display_name}} - {{$role->name}}
            </a>
        @else
            <span data-trigger="hover" data-html="true"
                  data-toggle="popover" title="Associated permissions">
                {{$role->display_name}} - {{$role->name}}
            </span>
        @endcan
        @can('delete roles')
            <form id="destroyRole{{$role->id}}"
                  action="{{route('roles.destroy', ['role'=>$role->id])}}"
                  method="post">
                @csrf
                @method('delete')
            </form>
            <button title="Remove" type="submit" form="destroyRole{{$role->id}}"
                    class="btn btn-sm btn-circle btn-danger destroy-btn">
                <i class="fa fa-times"></i>
            </button>
        @endcan
        <div class="permsList d-none">
            <ul class="list-group list-group-horizontal">
                @foreach($role->getPermissionNames() as $perm)
                    <li class="list-group-item">{{Str::title($perm)}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@if($role->childrenRecursive->count())
    <div class="list-group list-group-nested">
        @foreach($role->childrenRecursive as $data)
            @include('role.tree', ['role' => $data])
        @endforeach
    </div>
@endif