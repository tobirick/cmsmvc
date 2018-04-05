@extends('admin.partials.layout')
@section('title', $lang['Add new Page'])
@section('content-title', $lang['Add new Page'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pages" class="button-primary-border">{{$lang['Go back']}}</a>
    @endslot
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="admin-box">
                <form id="submit-form" action="/admin/pages" method="POST">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <div class="form-row">
                        <div class="col-12">
                            <input data-required="true" autocomplete="off" class="form-input pagenameinput validate" type="text" placeholder="Name" name="page[name]">
                            <strong>Permalink:</strong> <a target="_blank" class="aurl" href="{{$settings['siteurl']}}">{{$settings['siteurl']}}</a>
                        </div>
                    </div>
                    <div class="form-row dn">
                        <div class="col-12">
                            <input data-required="true" class="form-input pagesluginput validate" type="text" placeholder="Slug" name="page[slug]">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="baseurl" value="{{$settings['siteurl']}}">
</div>
@stop