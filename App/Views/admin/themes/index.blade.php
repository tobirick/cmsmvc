@extends('admin.partials.layout')
@section('title', 'Admin Themes')
@section('content-title', $lang['Themes'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/themes/create" class="button-primary">{{$lang['New Theme']}}</a>
    @endslot
@endcomponent
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <div class="row">
                        @foreach ($themes as $theme)
                            <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                                <div class="card {{$theme['name'] === $activetheme ? 'active-theme' : ''}}">
                                    <div class="card__title">{{$theme['name']}}</div>
                                    <div class="card__actions">
                                       <a href="/{{$curLang}}/admin/themes/{{$theme['id']}}/edit"><i class="fa fa-pencil"></i></a>
                                        <form action="/admin/themes/{{$theme['name']}}/{{$theme['id']}}" method="POST">
                                            <input type="hidden" name='_METHOD' value="PUT">
                                            <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                            <button><i class="fa fa-check {{$theme['name'] === $activetheme ? 'active' : ''}}"></i></button>
                                        </form>
                                        <form action="/admin/themes/{{$theme['name']}}/{{$theme['id']}}" method="POST">
                                            <input type="hidden" name='_METHOD' value="DELETE">
                                            <input name="csrf_token" type="hidden" value="{{$csrf}}">
                                            <button><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop