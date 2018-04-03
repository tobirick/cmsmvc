@extends('admin.partials.layout')
@section('title', $lang['Edit'] . " " . $user['name'])
@section('content-title')
{{$lang['Edit']}} '{{$user['name']}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/users" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div style="display: none;" data-bind="visible: mediaPopupVM().mediaPopupOpen, click: mediaPopupVM().closeMediaPopup" class="popup__overlay"></div>
@include('admin.popups.media-images-overview-popup')
<div id="content">
<div class="container">
    <div class="row">
        
        <form class="w-100 df" id="submit-form" action="/admin/users/{{$user['id']}}" method="POST">
            <input type="hidden" name='_METHOD' value="PUT">
            <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <div class="col-7">
            <div class="admin-box">
                <div class="form-row">
                  <div class="col-3">
                    <label for="username" class="form-label">Username</label>
                  </div>
                  <div class="col-9">
                    <input name="user[name]" type="text" class="form-input" value="{{$user['name']}}" placeholder="Username" id="username">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-3">
                    <label for="useremail" class="form-label">Email</label>
                  </div>
                  <div class="col-9">
                    <input name="user[email]" type="email" class="form-input" value="{{$user['email']}}" placeholder="E-Mail" id="useremail">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-3">
                    <label for="userrole" class="form-label">User Role</label>
                  </div>
                  <div class="col-9">
                    <select name="user[user_role_id]" id="userrole" class="form-input">
                      @foreach($userroles as $userrole)
                        <option value="{{$userrole['id']}}" {{$userrole['id'] === $user['user_role_id'] ? 'selected' : ''}}>{{$userrole['user_role_name']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="admin-box">
               <div class="form-row">
                <div class="col-3">
                  <label for="firstname" class="form-label">First Name</label>
                </div>
                <div class="col-9">
                  <input name="user[first_name]" type="text" class="form-input" value="{{$user['first_name']}}" placeholder="First Name" id="firstname">
                </div>
              </div>
              <div class="form-row">
                <div class="col-3">
                  <label for="lastname" class="form-label">Last Name</label>
                </div>
                <div class="col-9">
                  <input name="user[last_name]" type="text" class="form-input" value="{{$user['last_name']}}" placeholder="Last Name" id="firstname">
                </div>
              </div>
              <div class="form-row">
                <div class="col-3">
                  <label for="description" class="form-label">Description</label>
                </div>
                <div class="col-9">
                  <textarea name="user[user_desc]" type="text" class="form-input" placeholder="User desc" id="description">{{$user['user_desc']}}</textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="col-3">
                  <label for="userimg" class="form-label">Profile Image</label>
                </div>
                <div class="col-9">
                  <div class="center-v-flex">
                    <input type="text" name="user[user_img]" class="form-input" value="{{$user['user_img']}}" placeholder="Profile IMG SRC" id="userimg">
                    <button onclick="event.preventDefault()" data-bind="click: openMediaPopup" class="ml-1 button-primary">{{$lang['Choose Media']}}</button>
                  </div>
                  <div class="mt-2">
                      <div class="center-h-flex center-v-flex">
                         <img class="mw-100 user-img-preview box-shadow" style="width: 10rem;height:10rem; object-fit:cover;border-radius: 100%;border: 1px solid #ddd;" src="{{$user['user_img']}}">
                      </div>
                   </div>
                </div>
              </div>
            </div>
        </div>
    </form>
    </div>
</div>
@stop