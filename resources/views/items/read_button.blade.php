@if (Auth::user()->is_reading($item->code))
    {!! Form::open(['route' => 'item_user.dont_read', 'method' => 'delete']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('read', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
@else
    {!! Form::open(['route' => 'item_user.read']) !!}
        {!! Form::hidden('itemCode', $item->code) !!}
        {!! Form::submit('read it', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif