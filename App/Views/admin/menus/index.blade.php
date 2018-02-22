@extends('admin.partials.layout')
@section('title', 'Admin Menus')
@section('content-title', $lang['Menus'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/menus/create" class="button-primary">{{$lang['New Menu']}}</a>
    @endslot
@endcomponent
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <div class="row">
                        @if(isset($menus))
                        @foreach($menus as $menu)
                            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                <div class="card {{$menu['id'] === $allmenus['active_menu_id']['value'] ? 'active-menu' : ''}}">
                                    <div class="card__title">{{$menu['name']}}</div>
                                    <div class="card__actions">
                                        <a href="/{{$curLang}}/admin/menus/{{$menu['id']}}/edit"><i class="fa fa-pencil"></i></a>
                                        <form action="/admin/menus/{{$menu['id']}}" method="POST">
                                            <input type="hidden" name='_METHOD' value="DELETE">
                                            <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                            <button><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop