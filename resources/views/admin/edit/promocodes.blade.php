@extends('admin.vendor.crud')

@section('form')
    <form method="POST" action="{{ route('promocodes.update',$post->id) }}">
        @csrf
        @method('PATCH')

        <x-input name="promocode" :value="$post->promocode" pholder="Name of the promocode" label="Promocode" />

        <x-input name="discount" type="number" :value="$post->discount" pholder="Percent of discount" label="Discount (%)" />

        <x-input name="expired_at" type="date" :value="$post->pure_date" pholder="When this promocode expire" label="Expire at" />

        @include('admin.parts.form.button')
    </form>
@endsection
