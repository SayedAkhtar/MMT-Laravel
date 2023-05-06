@extends('layouts.video-call')

@section('content')
    <section id="app">
        <agora-chat :allusers="{{ $users }}" authuserid="{{ auth()->id() }}" authuser="{{ auth()->user()->name }}"
                    agora_id="{{ env('AGORA_APP_ID') }}"></agora-chat>
    </section>
@endsection
