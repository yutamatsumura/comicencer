@extends('layouts.app')

@section('content')
    <div class="user-profile">
        <div class="icon text-center">
            <img src="{{ Gravatar::src(Auth::user()->email, 100) . '&d=mm' }}" alt="" class="img-circle">
        </div>
        <div class="name text-center">
            <h1>{{ $user->name }}</h1>
            @include('user_follow.follow_button', ['user' => $user])
        </div>
        
        <div class="col-xs-12">
            <ul class="nav nav-tabs nav-justified">
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}"><a href="{{ route('users.show', ['id' => $user->id]) }}">Review <span class="badge">dummy</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}"><a href="{{ route('users.followings', ['id' => $user->id]) }}">Followings <span class="badge">{{ $count_followings }}</span></a></li>
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}"><a href="{{ route('users.followers', ['id' => $user->id]) }}">Followers <span class="badge">{{ $count_followers }}</span></a></li>
            </ul>
            <div class="status text-center">
                <ul>
                    <li>
                        <div class="status-label">WANT</div>
                        <div id="want_count" class="status-value">
                            {{ $count_want }}
                        </div>
                    </li>
                    <li>
                        <div class="status-label">READ</div>
                        <div id="read_count" class="status-value">
                            {{ $count_read }}
                        </div>
                    </li>
                </ul>
                @include('items.items', ['items' => $items])
                {!! $items->render() !!}
            </div>
        </div>
    </div>
@endsection