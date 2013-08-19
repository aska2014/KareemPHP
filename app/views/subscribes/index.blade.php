@extends('layout2.index')

@section('content')
<div id="content">

    <h1>Subscribing to <a href="{{ URL::route('home') }}">kareemphp.com</a></h1>
    <b>Email: <span>{{ $subscribeUser->email }}</span></b><br /><br />

    <h2>Subscribing options</h2>

    <form action="{{ URL::route('subscribe', 'step2') }}" method="POST">
        <input type="checkbox" name="Subscribe[options][new_tutorials]" checked="checked" /> Receiving new tutorials<Br />
        <input type="hidden" name="Subscribe[email]" value="{{ $subscribeUser->email }}" />
        <input type="submit" value="SUBSCRIBE !" class="subscribe_btn" />
    </form>

</div>
@stop