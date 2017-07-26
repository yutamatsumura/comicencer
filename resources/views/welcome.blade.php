@extends('layouts.app')

@section('cover')
    <div class="cover">
        <div class="cover-inner">
            <div class="cover-contents">
                <h1>新たな物語に出会う</h1>
                @if (!Auth::check())
                    <a href="{{ route('signup.get') }}" class="btn btn-success btn-lg">Join Comicencer</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (Auth::check())
        <?php $user = Auth::user(); ?>
        <div class="row">
            <div class="col-xs-12">
                @if (count($reviews) > 0)
                    @include('reviews.reviews', ['reviews' => $reviews])
                @endif
            </div>
        </div>

    
    @include('items.items')
    {!! $items->render() !!}
    @endif
@endsection