<x-main-layout :title="$classroom->name">
    <div class="container">
        <h1 data-classroom-id="{{ $classroom->id }}" class="ccc"> {{ $classroom->name }} (#{{ $classroom->id }})</h1>
        <h2 class="mb-3">Classworks
            @can('create', ['App\Model\Classwork', $classroom])
                <div class="dropdown d-inline-block">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        + Create
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'assignment']) }}">Assignment</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'material']) }}">Material
                            </a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'question']) }}">Question
                            </a></li>
                        <hr>
                        <li><a class="dropdown-item" id="tttt" href="#">Topic
                            </a></li>
                    </ul>
                </div>
            @endcan
        </h2>

        <hr>

        <x-alert name="success" id="success" class="alert-success" />

        <form action="{{ URL::current() }}" method="GET" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <input type="text" placeholder="Search..." name="search" class="form-control mb-2">
            </div>
            <div class="col-12">
                <button class="btn btn-primary ms-2 mb-2" type="submit">Find</button>
            </div>
        </form>

        <div class="accordion accordion-flush" id="accordionFlushExample">

            @foreach ($classworksWithoutTopic as $cwt)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse{{ $cwt->id }}" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            {{ $cwt->title }}
                        </button>
                    </h2>
                    <div id="flush-collapse{{ $cwt->id }}" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            {{ $cwt->description }}
                            <div>
                                <a class="btn btn-sm btn-outline-success "
                                    href="{{ route('classrooms.classworks.show', [$cwt->classroom_id, $cwt->id]) }}">View</a>
                                <a class="btn btn-sm btn-outline-dark "
                                    href="{{ route('classrooms.classworks.edit', [$cwt->classroom_id, $cwt->id]) }}">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ///////////////////////////////////////////////////////////////////////////// --}}

        @forelse ($topics as $topic)
            @if ($topic->classworks()->get()->first())
                <div class="d-flex algin-items-center justify-content-between mt-4">
                    <h4>{{ $topic->name }}</h4>
                    <x-drop-down :topic="$topic" :classroom="$classroom">
                        <li class="m-2"><a href="#" style="width:150px" id="tt"
                                data-topic-id="{{ $topic->id }}"
                                class="btn btn-sm btn-dark reject-button">Rename</a>
                        </li>
                    </x-drop-down>
                </div>
                <hr class="mt-2 mb-0" style="height: 2px; background-color:black ; opacity:1;">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($topic->classworks as $classwork)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    {{ $classwork->title }}
                                </button>
                            </h2>
                            <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    {{ $classwork->description }}
                                    <div>
                                        <a class="btn btn-sm btn-outline-success "
                                            href="{{ route('classrooms.classworks.show', [$classwork->classroom_id, $classwork->id]) }}">View</a>
                                        <a class="btn btn-sm btn-outline-dark "
                                            href="{{ route('classrooms.classworks.edit', [$classwork->classroom_id, $classwork->id]) }}">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @empty
            <p class="text-center fs-3">No classworks found.</p>

        @endforelse

        {{-- /////////////////////////////////////////////////////////// --}}

        @foreach ($topics as $topic)
            @if (!$topic->classworks()->get()->first())
                <div class="d-flex algin-items-center justify-content-between mt-4">
                    <h4>{{ $topic->name }}</h4>
                    <x-drop-down :topic="$topic" :classroom="$classroom">
                        <li class="m-2">
                            <a href="#" style="width:150px" id="tt" data-topic-id="{{ $topic->id }}"
                                class="btn btn-sm btn-dark reject-button">
                                Rename
                            </a>
                        </li>
                    </x-drop-down>
                </div>
                <hr class="mt-2 mb-5" style="height: 2px; background-color:black ; opacity:1">
            @endif
        @endforeach
    </div>
    <!-- Custom modal -->
</x-main-layout>

<div id="custom-modal">
    <div class="modal-content">
        <h3>Add topic</h3>
        <form action="{{ route('classrooms.topics.store', $classroom->id) }}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control aaa" id="user-input" name="name" placeholder="Topic">
                <label for="user-input">Topic</label>
            </div>
            <div class="button-container">
                <button type="submit" class="modal-button save-button" id="modal-save">Save</button>
                <button type="button" class="modal-button close-button" id="modal-close">Close</button>
            </div>
        </form>
    </div>
</div>

<div id="custom-modal2">
    <div class="modal-content2">
        <h3>Rename</h3>
        <form action="#" method="POST">
            @csrf
            @method('put')
            <div class="form-floating mb-3">
                <input type="text" class="form-control aaa2" id="user-input2" name="name"
                    placeholder="Rename">
                <label for="user-input2">Rename</label>
            </div>
            <div class="button-container2">
                <button type="submit" class="modal-button2 save-button2" id="modal-save2">Save</button>
                <button type="button" class="modal-button2 close-button2" id="modal-close2">Close</button>
            </div>
        </form>
    </div>
</div>
