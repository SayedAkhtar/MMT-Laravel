@extends('layouts.video-call')

@section('content')
    <h1>Hello</h1>
    <agora-chat :allusers="{{ $users }}" authuserid="{{ auth()->id() }}" authuser="{{ auth()->user()->name }}"
                agora_id="{{ env('AGORA_APP_ID') }}"></agora-chat>
@endsection
