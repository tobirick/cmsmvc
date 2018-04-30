@extends('admin.partials.layout')
@section('title', $lang['Pagebuilder Items'])
@section('content-title', $lang['Pagebuilder Items'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pagebuilder/create" class="button-primary">{{$lang['New Pagebuilder Item']}}</a>
    @endslot
@endcomponent
<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    <div class="row">
                        @if(sizeof($pagebuilderitems) > 0)
                        @foreach ($pagebuilderitems as $pagebuilderitem)
                            <div class="df col-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="card">
                                    <div class="card__title">{{$pagebuilderitem['item_name']}}</div>
                                    <div class="card__actions">
                                        <a href="/{{$curLang}}/admin/pagebuilder/{{$pagebuilderitem['id']}}/edit"><i class="fa fa-pencil"></i></a>
                                        <form class="delete-form" action="/admin/pagebuilder/{{$pagebuilderitem['id']}}" method="POST">
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
                            <span class="empty-state__icon"><i class="fa fa-building"></i></span>
                            <div class="empty-state__text">{{$lang['No Pagebuilder Elements']}}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop