<x-main-layout title="Trashed Classrooms">
    <div class="container">
        <h1 class="mb-4">Trashed Classrooms</h1>
        <x-alert name="success" id="success" class="alert-success" />
        <div class="row">
            @foreach ($classrooms as $classroom)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{ $classroom->cover_image_url }}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
                            <form action=" {{ route('classrooms.restore', $classroom->id) }} " method="post"
                                style="display: inline;">
                                @csrf
                                @method('put')
                                <button type="submit" style=" width:133px"
                                    class="btn btn-sm btn-success pt-1 pb-1">Restore</button>
                            </form>
                            <form action=" {{ route('classrooms.force-delete', $classroom->id) }} " method="post"
                                style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" style=" width:133px"
                                    class="btn btn-sm btn-danger pt-1 pb-1">Delete
                                    Forever</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-main-layout>
