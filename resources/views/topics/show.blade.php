<x-main-layout :title="$classroom->name">
    <div class="container">
        <h1> {{ $classroom->name }} (#{{ $classroom->id }})</h1>
        <h2 class="mb-5">Classworks - {{ $topic->name }}</h2>
        <x-alert name="success" id="success" class="alert-success" />

        <div class="d-flex algin-items-center justify-content-between mt-4">
            <h4>{{ $topic->name }}</h4>
            <x-drop-down :topic="$topic" :classroom="$classroom" />
        </div>
        <hr class="mt-2 mb-0" style="height: 2px; background-color:black ; opacity:1;">
        @forelse ($classworks as $classwork)
            <div class="accordion accordion-flush" id="accordionFlushExample">
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
                        </div>
                    </div>
                </div>
            </div>
        @empty

            <p class="text-center fs-3">No classworks found.</p>
        @endforelse




    </div>
    <!-- Custom modal -->

</x-main-layout>

</div>
