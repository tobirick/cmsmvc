@extends('admin.partials.layout')
@section('title', $lang['Change Settings'])
@section('content-title', $lang['Change Settings'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')
        <a id="submit-form-btn" href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <form id="submit-form" action="/admin/settings" method="POST">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <div class="row">
            <div class="col-7">
                <div class="admin-box">
                    <h3 class="admin-box__title">{{$lang['General Settings']}}</h3>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="title">{{$lang['Pagetitle']}}</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. PP IT-Systeme" value="{{$settings['sitetitle']}}" name="settings[sitetitle]" id="title" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="subtitle">{{$lang['Subtitle']}}</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. Das ist schön" name="settings[sitesubtitle]" value="{{$settings['sitesubtitle']}}" id="subtitle" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="sitedescription">{{$lang['Sitedescription']}}</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. Das ist schön" name="settings[sitedescription]" value="{{$settings['sitedescription']}}" id="sitedescription" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="url">Website URL</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. https://pp-systeme.de" name="settings[siteurl]" value="{{$settings['siteurl']}}" id="url" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="homepage">Home Page</label>
                        </div>
                        <div class="col-8">
                            <select name="settings[home_page_id]" id="homepage" class="form-input">
                                @foreach ($pages as $page)
                                    <option value="{{$page['id']}}" {{$page['id'] === $settings['home_page_id'] ? 'selected' : ''}}>{{$page['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="defaultlanguage">Default Language</label>
                        </div>
                        <div class="col-8">
                            <select name="settings[default_language_id]" id="defaultlanguage" class="form-input">
                              @foreach ($publicLanguages as $language)
                                 <option value="{{$language['id']}}" {{$language['id'] === $settings['default_language_id'] ? 'selected' : ''}}>{{$language['name']}}</option>
                             @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                           <label class="form-label">Maintenance Mode</label>
                        </div>
                        <div class="col-8">
                         <span class="form-checkbox">
                            <label for="mode">
                               <input value="1" name="settings[maintenance_mode]" class="form-checkbox__input" id="mode" type="checkbox" {{$settings['maintenance_mode'] ? 'checked' : ''}}>
                               <span class="form-checkbox__label">Active</span>
                            </label>
                         </span>
                        </div>
                     </div>
                </div>
            </div>
            <div class="col-5">
                <div class="admin-box">
                    <h3 class="admin-box__title">Mail Einstellungen</h3>
                    <span>(Coming soon ...)</span>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="emailsender">E-Mail Sender</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. mail@mail.de" name="settings[emailsender]" id="emailsender" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="emailreveicer">E-Mail Empfänger</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. mail@mail.de" name="settings[emailreveicer]" id="emailreveicer" class="form-input">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
@stop