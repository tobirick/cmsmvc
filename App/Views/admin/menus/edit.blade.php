@extends('admin.partials.layout')
@section('title', 'Edit Menu')
@section('content-title')
Edit '{{$menu['name']}}'
@stop

@section('content')
@component('admin.partials.secondary-navigation')
    @slot('left')
        <a href="/admin/menus" class="button-primary-border">Go back</a>
    @endslot
    @slot('right')
        <a href="#" class="button-primary">Save</a>
    @endslot
@endcomponent
<div id="content">
<div class="container">

    Edit Menu
    <form action="/admin/menus/{{$menu['id']}}" method="POST">
        <input type="hidden" name='_METHOD' value="PUT">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input value="{{$menu['name']}}" type="text" placeholder="Name" name="menu[name]">
        <input name="main-menu" type="checkbox" value="{{$menu['id']}}"> Main Menu
        <input name="footer-menu" type="checkbox" value="{{$menu['id']}}"> Footer Menu
        <button>Update Menu</button>
    </form>

    Add Menu Item
    <form action="/admin/menus/{{$menu['id']}}/menuitems" method="POST">
        <input name="csrf_token" type="hidden" value="{{$csrf}}">
        <input type="text" placeholder="Name" name="menuitem[name]">
        <select name="menuitem[page]">
            @foreach($pages as $page)
                <option value="{{$page['id']}}">{{$page['name']}}</option>
            @endforeach
        </select>
        <button>Add Menu Item</button>
    </form>
    
    Menu Items:<br>
    @if(isset($menuitems))
    <div>
    @foreach ($menuitems as $menuitem)
    <div>
        <form action="/admin/menus/{{$menu['id']}}/menuitems/{{$menuitem['id']}}" method="POST">
            <input type="hidden" name='_METHOD' value="PUT">
            <input name="csrf_token" type="hidden" value="{{$csrf}}">
            <input value="{{$menuitem['name']}}" type="text" placeholder="Name" name="menuitem[name]">
            <select name="menuitem[page]">
                @foreach($pages as $page)
                    <option value="{{$page['id']}}" {{ $menuitem['page_id'] === $page['id'] ? 'selected' : ''}}>{{$page['name']}}</option>
                @endforeach
            </select>
            <button>Edit Menu Item</button>
        </form>

        <form action="/admin/menus/{{$menu['id']}}/menuitems/{{$menuitem['id']}}" method="POST">
            <input type="hidden" name='_METHOD' value="DELETE">
            <input name="csrf_token" type="hidden" value="{{$csrf}}">
            <button>Delete Menu Item</button>
        </form>
    </div>
    @endforeach
    @endif
    </div>
</div>
</div>
@stop