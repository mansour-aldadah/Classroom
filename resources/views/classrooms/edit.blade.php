@extends('layouts.master')

@section('title', 'Edit Classrooms ' . $classroom->name)

@section('content')

    <div class="container">
        <h1>Edit Classroom</h1>
        <form action="{{ route('classrooms.update', $classroom->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            {{--
                <input type="hidden" name="_method" value="put">
                {{ method_field('put') }}
            --}}
            @method('put')
            @include('classrooms._form', [
                'button_label' => 'Update',
            ])
        </form>
    </div>

@endsection
