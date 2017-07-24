@extends('layouts.app')

@section('content')
    <h1>Readランキング</h1>
    @include('items.items', ['items' => $items])
@endsection