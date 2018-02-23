@extends('admin.partials.layout')
@section('title', 'Edit Page')
@section('content-title')
{{$lang['Edit']}} '{{$name}}'
@stop

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
        <div class="col-8">

            <div class="admin-box">
                <form id="submit-form" action="/admin/pages/{{$id}}" method="POST">
                    <input type="hidden" name='_METHOD' value="PUT">
                    <input name="csrf_token" type="hidden" value="{{$csrf}}">
                    <div class="form-row">
                        <input class="form-input" value="{{$slug}}" type="text" placeholder="Slug" name="page[slug]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="{{$name}}" type="text" placeholder="Name" name="page[name]">
                    </div>
                    <div class="form-row">
                        <input class="form-input" value="{{$title}}" type="text" placeholder="Title" name="page[title]">
                    </div>
                    <div class="form-row">
                        <textarea class="form-input" name="page[content]">{{$content}}</textarea>
                    </div>
                </form>
            </div>

            <div class="admin-box">
                <div class="row">
                    <div class="admin-grid-section">
                        <div class="admin-grid-section__action">
                            <button><i class="fa fa-bars"></i></button>
                            <button><i class="fa fa-clone"></i></button>
                            <button><i class="fa fa-times"></i></button>
                        </div>
                        <div class="admin-grid-rows">
                            <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <span class="admin-grid__add-row"><i class="fa fa-plus"></i> Add Row</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="admin-grid-section">
                        <div class="admin-grid-section__action">
                            <button><i class="fa fa-bars"></i></button>
                            <button><i class="fa fa-clone"></i></button>
                            <button><i class="fa fa-times"></i></button>
                        </div>
                        <div class="admin-grid-rows">
                            <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <div class="admin-grid-row">
                            <div class="admin-grid-row__action">
                                <button><i class="fa fa-bars"></i></button>
                                <button><i class="fa fa-clone"></i></button>
                                <button><i class="fa fa-times"></i></button>
                            </div>
                            <div class="admin-grid-cols">
                                <div class="admin-grid-col">
                                    <i class="fa fa-arrows"></i> Drop Column(s) here
                                </div>
                            </div>
                        </div>
                        <span class="admin-grid__add-row"><i class="fa fa-plus"></i> Add Row</span>
                        </div>
                    </div>
                    <span class="admin-grid__add-section"><i class="fa fa-plus"></i> Add Section</span>
                </div>
            </div>
            
        </div>
        <div class="col-4">
            <div id="fixed-sidebar">
            <div class="admin-box">
                <h3 class="admin-box__title">Grid</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">12</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">9</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">8</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">6</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">4</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">3</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                            <div class="admin-grid-list-item">
                                <span class="admin-grid-list-item__number">2</span>
                                <span class="admin-grid-list-item__icon"></span>
                            </div>
                        </div>
                </div>
            </div>

            <div class="admin-box">
                <h3 class="admin-box__title">Elements</h3>
            </div>
            </div>
        </div>
    </div>
</div>
@stop