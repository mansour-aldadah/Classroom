@extends('layouts.master')

@section('title', 'Create Classrooms')

@section('content')

    <div class="container">
        <h1>Create Classroom</h1>

        <x-all-error />

        <form action="{{ route('classrooms.store') }}" method="post" enctype="multipart/form-data">
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{ csrf_field() }} --}}
            @csrf
            @include('classrooms._form', [
                'button_label' => 'Create Classroom',
            ])
        </form>
    </div>

@endsection
