<x-alert name="error" id="error" class="alert-danger" />

<x-form.floating-control name="name">
    <x-slot:label>
        <label for="name">Classroom Name</label>
    </x-slot:label>
    <x-form.input value="{{ $classroom->name }}" name="name" placeholder="Classroom Name" />
</x-form.floating-control>

<x-form.floating-control name="section">
    <x-slot:label>
        <label for="name">Section</label>
    </x-slot:label>
    <x-form.input value="{{ $classroom->section }}" name="section" placeholder="Section" />
</x-form.floating-control>

<x-form.floating-control name="subject">
    <x-slot:label>
        <label for="name">Subject</label>
    </x-slot:label>
    <x-form.input value="{{ $classroom->subject }}" name="subject" placeholder="Subject" />
</x-form.floating-control>

<x-form.floating-control name="room">
    <x-slot:label>
        <label for="name">Room</label>
    </x-slot:label>
    <x-form.input value="{{ $classroom->room }}" name="room" placeholder="Room" />
</x-form.floating-control>


<x-form.floating-control name="cover_image">
    @if ($classroom->cover_image_url)
        <img src="{{ $classroom->cover_image_url }}" class="card-img-top" alt="">
    @endif
    <x-slot:label>
        <label for="name">Cover Image</label>
    </x-slot:label>
    <x-form.input type="file" value="{{ $classroom->cover_image }}" name="cover_image" placeholder="Cover Image" />
</x-form.floating-control>

<button type="submit" class="btn btn-primary">{{ $button_label }}</button>
