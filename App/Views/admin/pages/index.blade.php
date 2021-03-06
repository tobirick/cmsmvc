@extends('admin.partials.layout')
@section('title', $lang['Pages'])
@section('content-title', $lang['Pages'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pages/create" class="button-primary">{{$lang['New Page']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                @if(sizeof($pagesadmin) > 0)
                <div class="">
                    <table class="table scale">
                        <thead>
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th>{{$lang['Name']}}</th>
                                <th class="center" style="width: 10%;">Status</th>
                                <th style="width: 15%;">{{$lang['Author']}}</th>
                                <th style="width: 20%;">{{$lang['Date']}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($pagesadmin as $page)
                            <tr data-editlink="/{{$curLang}}/admin/pages/{{$page['id']}}/edit" class="open-page-edit">
                                <td class="name" style="width: 10%;">{{$page['id']}}</td>
                                <td class="name"><strong>{{$page['name']}}</strong><br><span class="light-text smaller-text">/{{$page['slug']}}</span></td>
                            <td class="center name" style="width: 10%;"><div class="bullet {{$page['is_active'] ? 'active' : 'inactive'}}"></div></td>
                                <td class="name" style="width: 15%;">{{$page['author']}}</td>
                                <td class="name" style="width: 20%;"><span class="smaller">Published</span><br>{{date_format(new DateTime($page['created_at']), 'd.m.Y')}}</td>
                                <td class="action auto-width">
                                    <a href="/{{$curLang}}/admin/pages/{{$page['id']}}/edit"><i class="fa fa-pencil"></i></a>
                                    <a target="_blank" href="/{{$page['slug']}}"><i class="fa fa-arrow-right"></i></a>
                                    <form class="delete-form" action="/admin/pages/{{$page['id']}}" method="POST">
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
                @component('admin.components.pagination', ['currentpage' => $currentpage, 'numberofpages' => $numberofpages])@endcomponent
                @else
                <div class="empty-state">
                    <span class="empty-state__icon"><i class="fa fa-file"></i></span>
                    <div class="empty-state__text">No Pages ...</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@stop