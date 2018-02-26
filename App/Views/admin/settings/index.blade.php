@extends('admin.partials.layout')
@section('title', 'Admin Settings')
@section('content-title', $lang['Change Settings'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')
        <a href="#" class="button-primary">{{$lang['Save']}}</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">
    <form action="">
        <div class="row">
            <div class="col-7">
                <div class="admin-box">
                    <h3 class="admin-box__title">Allgemeine Einstellungen</h3>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="title">Titel der Seite</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. PP IT-Systeme" name="settings[title]" id="title" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="subtitle">Untertitel</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. Das ist schön" name="settings[subtitle]" id="subtitle" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="url">Website URL</label>
                        </div>
                        <div class="col-8">
                            <input type="text" placeholder="z.B. https://pp-systeme.de" name="settings[url]" id="url" class="form-input">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-4">
                            <label class="form-label" for="language">Sprache der Website</label>
                        </div>
                        <div class="col-8">
                            <select name="settings[language]" id="language" class="form-input">
                                @foreach($allLanguages as $language)
                                    <option value="{{$language['shortName']}}" {{$curLang === $language['shortName'] ? 'selected' : ''}}>{{$language['longName']}}</option>
                                 @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="admin-box">
                    <h3 class="admin-box__title">Mail Einstellungen</h3>
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