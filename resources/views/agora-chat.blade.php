@extends('layouts.video-call')

@section('content')
    <section id="app">
        <agora-chat authuserid="{{ auth()->id() ?? rand(1,1000) }}" authuser="{{ auth()->user()->name?? "User" }}"
                    agora_id="{{ env('AGORA_APP_ID') }}" channel-name="{{ $channel_name }}"></agora-chat>
    </section>
@endsection
