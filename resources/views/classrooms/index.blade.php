<x-main-layout title="{{ __('Classrooms') }}">
    <div class="container">
        <h1 class="mb-4">{{ __('Classrooms') }}</h1>
        <x-alert name="success" id="success" class="alert-success" />
        {{-- <x-alert name="error" id="error" class="alert-danger" /> --}}
        <form action="{{ URL::current() }}" method="GET" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <input type="text" placeholder="Search..." name="search" class="form-control mb-3">
            </div>
            <div class="col-12">
                <button class="btn btn-primary ml-1 mb-3" type="submit">Find</button>
            </div>
        </form>
        <div class="row mb-3">
            @foreach ($classrooms as $classroom)
                <x-classroom-card :classroom="$classroom" />
            @endforeach
        </div>
        {{ $classrooms->withQueryString()->links() }}
    </div>
</x-main-layout>
