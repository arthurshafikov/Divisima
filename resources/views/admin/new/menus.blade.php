@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('menus.store') }}">
        @csrf

        <x-input name="name" :value="old('name')" placeholder="Name of the menu" label="Menu" />

        <x-input name="location" :value="old('location')" placeholder="Location of the menu" label="Location" />

        <x-multiple-items :name="['item_names','item_links']" :pholder="['Name of the item','Links of the item']" :columns="['name','path']" :post="null" iterable="null" />
        
        @include('admin.parts.form.button')
    </form>
@endsection
