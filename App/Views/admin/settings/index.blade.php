@extends('admin.partials.layout')
@section('title', 'Admin Settings')
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
                    <h3 class="admin-box__title">Allgemeine Einstellungen</h3>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="title">Titel der Seite</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. PP IT-Systeme" value="{{$settings['sitetitle']}}" name="settings[sitetitle]" id="title" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="subtitle">Untertitel</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. Das ist schön" name="settings[sitesubtitle]" value="{{$settings['sitesubtitle']}}" id="subtitle" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="sitedescription">Seitenbeschreibung</label>
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