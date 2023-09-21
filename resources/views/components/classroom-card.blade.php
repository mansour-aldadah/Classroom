<div class="col-md-3">
    <div class="card">
        <img src="{{ $classroom->cover_image_url }}" class="card-img-top" alt="">

        <div class="card-body">
            <h5 class="card-title">{{ $classroom->name }}</h5>
            <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
            <a href="{{ route('classrooms.show', $classroom->id) }}" style="width:87px"
                class="btn btn-sm btn-primary">{{ __('View') }}</a>
            <a href="{{ route('classrooms.edit', $classroom->id) }}" style="width:87px"
                class="btn btn-sm btn-dark">{{ __('Edit') }}</a>
            <form action=" {{ route('classrooms.destroy', $classroom->id) }} " method="post" style="display: inline;">
                @csrf
                @method('delete')
                <button type="submit" style="width:87px" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
            </form>
        </div>
    </div>
</div>
