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
<div id="content">
<div class="container">
    <div class="row">
        
        <form class="w-100 df" id="submit-form" action="/admin/users/{{$user['id']}}" method="POST">
            <input type="hidden" name='_METHOD' value="PUT">
            <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <div class="col-7">
            <div class="admin-box">
               <h3 class="admin-box__title">Default Settings</h3>
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
               <h3 class="admin-box__title">Title</h3>

            </div>
        </div>
    </form>
    </div>
</div>
@stop