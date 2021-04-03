@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('menus.update',$post) }}" class="menu-edit">
        @csrf
        @method('PATCH')
        <x-input name="name" :value="$post->name" pholder="Name of the menu" label="Menu" />

        <x-input name="location" :value="$post->location" pholder="Location of the menu" label="Location" />

        <x-multiple-items :name="['item_names','item_links']" :pholder="['Name of the item','Links of the item']" :columns="['name','path']" :post="$post" iterable="items" />

        @include('admin.parts.form.button')
    </form>
@endsection
