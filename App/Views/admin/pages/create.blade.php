@extends('admin.partials.layout')
@section('title', 'Create Page')
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
                        <input class="form-input pagenameinput" type="text" placeholder="Name" name="page[name]">
                        <a target="_blank" class="aurl" href=""></a>
                    </div>
                    <div style="display: none;" class="form-row">
                        <input class="form-input pageluginput" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" type="text" placeholder="Title" name="page[title]">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="baseurl" value="{{$settings['siteurl']}}">
</div>
<script>
    const nameInputEl = document.querySelector('.pagenameinput');
    const slugInputEl = document.querySelector('.pageluginput');
    const aUrlEl = document.querySelector('.aurl');
    const baseurl = document.querySelector('.baseurl').value;

    nameInputEl.addEventListener('keyup', () => {
        const pageName = nameInputEl.value;
        const newSlug = createSlug(pageName);

        aUrlEl.innerHTML = `${baseurl}${newSlug}`;
        aUrlEl.setAttribute('href', `${baseurl}${newSlug}`);
        slugInputEl.value = newSlug;
    });

    const createSlug = (text) => {
        return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, ''); 
    }
</script>
@stop