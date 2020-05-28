<div class="card-img-top d-flex flex-wrap align-items-center bg-light p-3">
    <img width="100" height="100" class="rounded-circle mr-4 profile-picture" data-toggle="modal"
         data-target="#profilePicModal"
         src="{{$employee->avatar??asset('images/no_avatar.jpg')}}"
         alt="Avatar">
    <div class="d-inline-flex flex-wrap justify-content-start align-content-center">
        <h3 class="w-100">{{$employee->fullName}}</h3>
        <p class="text-secondary mb-1 w-100">{{$employee->department->name}}
            : {{$employee->role}}</p>
        <p class="text-secondary m-0 d-inline pr-3 mr-3 border-right">{{$employee->email}}</p>
        <p class="text-secondary m-0 d-inline pr-3" data-toggle="tooltip" data-placement="right"
           title="{{__('Your EmployeeID')}}">#{{$employee->id}}</p>
    </div>
</div>
<div class="modal fade" id="profilePicModal" tabindex="-1" role="dialog"
     aria-labelledby="profilePicModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profilePicModalTitle">{{__('Profile picture')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0">
                <img class="profile-picture-lg" src="{{$employee->avatar??asset('images/no_avatar.jpg')}}"
                     alt="avatar">
                <div id="uploadPlayground">
                </div>
                <div class="d-flex justify-content-evenly align-items-center img-actions">
                    <span class="cancel-img img-action"><i class="fas fa-times"></i> {{__('Cancel')}}</span>
                    <span class="apply-img img-action"><i class="fas fa-check"></i> {{__('Apply')}}</span>
                    <label for="avatar" class="upload-img img-action m-0"><i class="fas fa-camera"></i> {{__('Upload')}}
                    </label>
                </div>
                <form method="post" id="avatarForm" action="{{route('profile.update-avatar')}}"
                      enctype="multipart/form-data">
                    <input type="file" name="avatar" id="avatar" class="d-none">
                </form>
            </div>
        </div>
    </div>
</div>