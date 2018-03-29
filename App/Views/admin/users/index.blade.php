@extends('admin.partials.layout')
@section('title', $lang['Users'])
@section('content-title', $lang['Users'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/users/create" class="button-primary">{{$lang['New User']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th>{{$lang['Name']}}</th>
                            <th>E-Mail</th>
                            <th>{{$lang['Role']}}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td style="width: 10%;">{{$user['id']}}</td>
                            <td><strong>{{$user['name']}}</strong></td>
                            <td>{{$user['email']}}</td>
                            <td>{{$user['role_name'] ? $user['role_name'] : 'No Role'}}</td>
                            <td class="action auto-width">
                                <a href="/{{$curLang}}/admin/users/{{$user['id']}}/edit"><i class="fa fa-pencil"></i></a>
                                <form class="delete-form" action="/admin/users/{{$user['id']}}" method="POST">
                                    <input type="hidden" name='_METHOD' value="DELETE">
                                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                    <button><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@stop