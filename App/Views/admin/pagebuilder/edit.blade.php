@extends('admin.partials.layout')
@section('title', 'Edit Pagebuilder Item')
@section('content-title')
{{$lang['Edit']}} '{{$item_name}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/{{$curLang}}/admin/pagebuilder" class="button-primary-border">{{$lang['Go back']}}</a>
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
                   <form id="submit-form" method="POST" action="/admin/pagebuilder/{{$id}}">
                        <input type="hidden" name='_METHOD' value="PUT">
                        <input name="csrf_token" type="hidden" value="{{$csrf}}">
                        <div class="form-row">
                            <input placeholder="Name" value="{{$item_name}}" class="form-input" type="text" name="item[name]">
                        </div>
                        <div class="form-row">
                            <textarea placeholder="Content" class="form-input" name="item[content]">{{$item_content}}</textarea>
                        </div>
                        <div class="form-row">
                             <input placeholder="Type" value="{{$item_type}}" class="form-input" name="item[type]">
                        </div>
                        <div class="form-row">
                             <input placeholder="Description" value="{{$item_description}}" class="form-input" name="item[description]">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop