@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
            <div class="item">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <img src="{{ $item->image_url }}" alt="">
                    </div>
                    <div class="panel-body">
                        <p class="item-title">{{ $item->name }}</p>
                        <div class="buttons text-center">
                            @if (Auth::check())
                                @include('items.want_button', ['item' => $item])
                                @include('items.read_button', ['item' => $item])
                            @endif
                        </div>
                        <div>
                            <p class="text-center"><a href="{{ $item->url }}" target="_blank">楽天詳細ページへ</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="want-users">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        Wantしたユーザ
                    </div>
                    <div class="panel-body">
                        @foreach ($want_users as $user)
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="read-users">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        Readしたユーザ
                    </div>
                    <div class="panel-body">
                        @foreach ($read_users as $user)
                            <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            
            
            {!! Form::open(['route' => ['reviews.store', $item->id]]) !!}
                <div class="form-group">
                    {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '5']) !!}
                </div>
                {!! Form::submit('Review', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
            
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12 col-md-offset-3">
            <p>ユーザーレビュー　：　{{ count($reviews) }}　件　</p> 
            @if (count($reviews) > 0)
                @include('reviews.reviews', ['reviews' => $reviews])
            @endif
        </div>
    </div>
@endsection