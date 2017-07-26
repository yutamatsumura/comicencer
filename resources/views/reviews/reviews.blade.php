<ul class="media-list">
@foreach ($reviews as $review)
    <?php $user = $review->user; ?>
    <?php $item = $review->item; ?>
    <li class="media">
        <div class="media-left">
            <img src="{{ Gravatar::src(Auth::user()->email, 100) . '&d=mm' }}" alt="" class="img-circle">
        </div>
        <div class="media-body">
            <div>
                {!! link_to_route('users.show', $user->name, ['id' => $user->id]) !!} <span class="text-muted">posted at {{ $review->created_at }}</span>
            </div>
            <div>
                <p>{!! nl2br(e($review->content)) !!}</p>
            </div>
            <div>
                <p> Review ------->  {!! link_to_route('items.show', $item->name, ['id' => $item->id]) !!} <span class="text-muted"></span></p>
                @if (Auth::user()->id == $review->user_id)
                    {!! Form::open(['route' => ['reviews.destroy', $review->id], 'method' => 'delete']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
        </div>
        <a class="review-line"><img src="{{ asset('images/line1.png') }}" alt=“line1”></a>
    </li>
@endforeach
</ul>
