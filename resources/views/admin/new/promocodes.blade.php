@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('promocodes.store') }}">
        @csrf

        <x-input name="promocode" :value="old('promocode')" placeholder="Name of the promocode" label="Promocode" />
        
        <x-input name="discount" type="number" :value="old('discount')" placeholder="Percent of discount" label="Discount (%)" />

        <x-input name="expired_at" type="date" :value="old('expired_at')" placeholder="When this promocode expire" label="Expire at" />
        
        
        @include('admin.parts.form.button')
        
    </form>
@endsection
