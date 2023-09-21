<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class ClassroomsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->authorizeResource(Classoom::class);
    }
    public function index(Request $request): Renderable
    {
        $this->authorize('view-any', Classroom::class);

        $classrooms = Classroom::status('active')
            ->recent()
            ->orderBy('created_at')
            ->filter($request->query())
            ->paginate(4);
        $success = session('success');
        return view('classrooms.index', [
            'classrooms' => $classrooms,
            'success' => $success,
        ]);
    }
    public function create()
    {
        return view('classrooms.create', [
            'classroom' => new Classroom(),
        ]);
    }
    public function show(Classroom $classroom)
    {
        // $classroom = Classroom::findOrFail($id);

        $invitation_link = URL::signedRoute('classrooms.join', [
            'classroom' => $classroom->id,
            'code' => $classroom->code,
        ]);

        return view('classrooms.show', [
            'classroom' => $classroom,
            'invitation_link' => $invitation_link,
        ]);
    }
    public function edit(Classroom $classroom)
    {
        // $classroom = Classroom::findOrFail($id);

        return view('classrooms.edit', [
            'classroom' => $classroom
        ]);
    }
    public function update(ClassroomRequest $request, Classroom $classroom): RedirectResponse
    {
        // $classroom = Classroom::findOrFail($id);

        $old = $classroom->cover_image_path;

        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = Classroom::uploadCoverImage($file);
            // $request->merge([
            //     'cover_image_path' => $path,
            // ]);
            $validated['cover_image_path'] = $path;
        }
        $classroom->update($validated);
        if ($old && $old != $classroom->cover_image_path) {
            Classroom::deleteCoverImage($old);
        }
        return redirect(route('classrooms.index'))
            ->with('success', 'Classroom updated')
            ->with('error', 'Classroom updated');
    }

    public function store(ClassroomRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        // $classroom = new Classroom();
        // $classroom->name = $request->post('name');
        // $classroom->section = $request->post('section');
        // $classroom->subject = $request->post('subject');
        // $classroom->room = $request->post('room');
        // $classroom->code = Str::random(8);
        // $classroom->user_id = 1;
        // $classroom->save();
        // return redirect(route('classrooms.index'));

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $path = Classroom::uploadCoverImage($file);
            // $request->merge([
            //     'cover_image_path' => $path,
            // ]);
            $validated['cover_image_path'] = $path;
        }

        // $request->merge([
        //     'code' => Str::random(8),
        //     'user_id' => 1,
        // ]);

        // $validated['code'] = Str::random(8);
        // $validated['user_id'] = Auth::id();

        DB::beginTransaction();

        try {
            $classroom = Classroom::create($validated);
            $classroom->join(Auth::id(), 'teacher');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('classrooms.index')
            ->with('success', 'Classroom created');
    }
    public function destroy(Classroom $classroom)
    {
        // Classroom::destroy($id);
        // $classroom = Classroom::find($id);
        $classroom->delete();
        // Classroom::deleteCoverImage($classroom->cover_image_path);

        return redirect(route('classrooms.index'))
            ->with('success', 'Classroom deleted');
    }

    public function trashed()
    {
        $classrooms = Classroom::onlyTrashed()->latest('deleted_at')->get();
        return view('classrooms.trashed', compact('classrooms'));
    }

    public function restore($id)
    {
        $classroom = Classroom::onlyTrashed()->findOrFail($id);
        $classroom->restore();
        return redirect(route('classrooms.index'))
            ->with('success', "Classroom ({$classroom->name}) restored");
    }

    public function forceDelete($id)
    {
        $classroom = Classroom::withTrashed()->findOrFail($id);
        $classroom->forceDelete();
        // Classroom::deleteCoverImage($classroom->cover_image_path);
        return redirect(route('classrooms.trashed'))
            ->with('success', "Classroom ({$classroom->name}) deleted forever!");
    }
}
