@extends('admin.partials.layout')
@section('title', $lang['Language Settings'])
@section('content-title', $lang['Language Settings'])

@section('content')
@component('admin.partials.secondary-navigation')
   @slot('left')
        <a href="/{{$curLang}}/admin/settings/languages/create" class="button-primary">{{$lang['New Language']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
   <div class="row">
      <div class="col-12">
          <div class="admin-box">
            <div class="row">
               @foreach($languages as $language)
               <div class="col-12 col-md-4 col-lg-3 col-xl-2">
                  <div class="card">
                     <div class="card__title"><span class="flag-icon flag-icon-{{$language['iso']}}"></span> {{$language['name']}}</div>                     
                     <div class="card__actions">
                     <a href="/{{$curLang}}/admin/settings/languages/{{$language['id']}}/edit"><i class="fa fa-pencil"></i></a>
                        <form class="delete-form" action="/admin/settings/languages/{{$language['id']}}" method="POST">
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