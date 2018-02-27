@extends('admin.partials.layout')
@section('title', 'Create Pagebuilder Item')
@section('content-title', 'Create Pagebuilder Item')

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
                     <form id="submit-form" method="POST" action="/admin/pagebuilder">
                          <input name="csrf_token" type="hidden" value="{{$csrf}}">
                          <div class="form-row">
                              <input placeholder="Name" class="form-input" type="text" name="item[name]">
                         </div>
                         <div class="form-row">
                             <textarea placeholder="Content" class="form-input" name="item[content]"></textarea>
                        </div>
                        <div class="form-row">
                             <input placeholder="Type" class="form-input" name="item[type]">
                        </div>
                        <div class="form-row">
                             <input placeholder="Description" class="form-input" name="item[description]">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop