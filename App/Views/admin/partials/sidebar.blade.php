<aside class="main-sidebar">
    <a class="main-sidebar__title" href="/admin/dashboard"><h1>PP<span>CMS</span></h1></a>
    @include('admin.partials.navigation')

    <div class="main-sidebar__language-changer">
        <select class="form-input" id="langChange" name="lang">
            @foreach($allLanguages as $lang)
                <option value="{{$lang['shortName']}}" {{$curLang === $lang['shortName'] ? 'selected' : ''}}>{{$lang['longName']}}</option>
            @endforeach
        </select>
    </div>
</aside>