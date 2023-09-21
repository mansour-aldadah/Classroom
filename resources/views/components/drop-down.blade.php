@props([
    'topic' => $topic,
    'classroom' => $classroom,
])

<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false"></button>
    <ul class="dropdown-menu">
        <li class="m-2"><a href="{{ route('classrooms.topics.show', compact(['classroom', 'topic'])) }}"
                style="width:150px" class="btn btn-sm btn-primary">View</a></li>
        {{ $slot }}
        <li class="m-2">
            <form action=" {{ route('classrooms.topics.destroy', [$classroom->id, $topic->id]) }} " method="post"
                style="display: inline;">
                @csrf
                @method('delete')
                <button type="submit"style="width:150px" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </li>
    </ul>
</div>
