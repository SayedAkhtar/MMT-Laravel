@extends('layouts.video-call')

@section('content')
    <section id="app">
        <agora-chat authuserid="{{ auth()->id() }}" authuser="{{ auth()->user()->name }}"
                    agora_id="{{ env('AGORA_APP_ID') }}" channel-name="{{ $channel_name }}"></agora-chat>
    </section>
@endsection
