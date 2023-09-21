<x-main-layout title="Create classwork">
    <div class="container">
        <h1> {{ $classroom->name }} (#{{ $classroom->id }})</h1>
        <h3>Create Classwork</h3>
        <hr>
        <form action="{{ route('classrooms.classworks.store', [$classroom->id, 'type' => $type]) }}" method="POST">
            @csrf
            @include('classworks._form')
            <button type="submit" class="btn btn-primary">Create Classwork</button>
        </form>
    </div>

</x-main-layout>
