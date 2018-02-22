@extends('admin.partials.layout')
@section('title', 'Admin Pagebuilder Items')
@section('content-title', 'Pagebuilder Items')

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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop