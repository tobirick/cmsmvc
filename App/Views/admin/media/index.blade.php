@extends('admin.partials.layout')
@section('title', 'Admin Media Manager')
@section('content-title', $lang['Media Manager'])

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('right')

    @endslot
@endcomponent
<div id="content">
<div class="container">
        <div class="row">
            <div class="col-12">
                <div class="admin-box">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop