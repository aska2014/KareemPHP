@extends('layout1.index')

@section('content')
<div id="content">
    <div class="main_tobic">

        <h1>{{ $messenger->getTitle() }}</h1>


        <p>
            {{ $messenger->getDescription() }}
        </p>

    </div>
</div>
@stop