@extends('admin.partials.layout')
@section('title', 'Admin Pages')
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
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">#</th>
                            <th>Name</th>
                            <th style="width: 10%;">Autor</th>
                            <th style="width: 20%;">Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pagesadmin as $page)
                        <tr>
                            <td style="width: 10%;">{{$page['id']}}</td>
                            <td><strong>{{$page['name']}}</strong><br><span class="light-text smaller-text">/{{$page['slug']}}</span></td>
                            <td style="width: 10%;">{{$page['author']}}</td>
                            <td style="width: 20%;">{{date_format(new DateTime($page['created_at']), 'd.m.Y')}}</td>
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