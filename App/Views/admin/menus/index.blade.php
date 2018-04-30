@extends('admin.partials.layout')
@section('title', $lang['Menus'])
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
                        @if(isset($menus) && sizeof($menus) > 0)
                        @foreach($menus as $menu)
                            <div class="df col-12 col-md-4 col-lg-3 col-xl-2">
                                <div class="card {{$menu['id'] === $allmenus['active_menu_id']['value'] ? 'active-menu' : ''}}">
                                    <div class="card__title">{{$menu['name']}}</div>
                                    <div class="card__actions">
                                        <a href="/{{$curLang}}/admin/menus/{{$menu['id']}}/edit"><i class="fa fa-pencil"></i></a>
                                        <form class="delete-form" action="/admin/menus/{{$menu['id']}}" method="POST">
                                            <input type="hidden" name='_METHOD' value="DELETE">
                                            <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                            <button><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                        <div class="empty-state">
                            <span class="empty-state__icon"><i class="fa fa-bars"></i></span>
                            <div class="empty-state__text">{{$lang['No Menus']}}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop