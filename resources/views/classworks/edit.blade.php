<x-main-layout title="Update classwork">
    <div class="container">
        <h1> {{ $classroom->name }} (#{{ $classroom->id }})</h1>
        <h3>Update Classwork</h3>
        <x-alert name="success" id="success" class="alert-success" />
        <hr>
        <form action="{{ route('classrooms.classworks.update', [$classroom->id, $classwork->id, 'type' => $type]) }}"
            method="POST">
            @csrf
            @method('put')
            @include('classworks._form')

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

</x-main-layout>
