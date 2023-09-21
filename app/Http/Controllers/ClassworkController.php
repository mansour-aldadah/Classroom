<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Classwork;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;

class ClassworkController extends Controller
{

    protected function getType(Request $request)
    {
        $type = $request->query('type');
        $allowed_type = [
            Classwork::TYPE_ASSIGNMENT, Classwork::TYPE_MATERIAL, Classwork::TYPE_QUESTION
        ];
        if (!in_array($type, $allowed_type)) {
            $type = Classwork::TYPE_ASSIGNMENT;
        }
        return $type;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Classroom $classroom)
    {
        $this->authorize('viewAny', [Classwork::class, $classroom]);
        $classworksWithoutTopic = $classroom->classworks()
            ->where('topic_id', null)
            ->latest('published_at')
            ->filter($request->query())
            ->get();

        $topics = $classroom->topics()->with(['classworks' => function ($query2) use ($request) {
            $query2->where(function ($subquery) use ($request) {
                $subquery->where('title', 'LIKE', "%{$request->search}%")
                    ->orWhere('description', 'LIKE', "%{$request->search}%");
            });
        }])->filter($request->query())->get();

        return view('classworks.index', [
            'classroom' => $classroom,
            'classworksWithoutTopic' => $classworksWithoutTopic,
            'topics' => $topics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {
        // Gate::authorize('classworks.create', [$classroom]);
        $this->authorize('create', [Classwork::class, $classroom]);
        // if (!Gate::allows('classworks.create', [$classroom])) {
        //     abort(403);
        // }
        $type = request('type');
        $classwork = new Classwork();
        return view('classworks.create', compact('classroom', 'classwork', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        // if (Gate::denies('classworks.create', [$classroom])) {
        //     abort(403);
        // }
        $this->authorize('create', [Classwork::class, $classroom]);

        $type = request('type');
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => [Rule::requiredIf(fn () => $type == 'assignment'), 'date', 'after:published_at'],
        ]);
        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type,
            // 'classroom_id' => $classroom->id,
        ]);
        try {
            DB::transaction(function () use ($classroom, $request, $type) {

                $classwork = $classroom->classworks()->create($request->all());
                // Classwork::create($request->all());
                $classwork->users()->attach($request->input('students'));
            });
        } catch (QueryException $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()
            ->route('classrooms.classworks.index', $classroom->id)
            ->with('success', __('Classwork created!'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Classwork $classwork)
    {
        // $classwork->load('comments.user');
        // Gate::authorize('classworks.view', [$classwork]);
        $this->authorize('view', $classwork);

        $submissions = Auth::user()
            ->submissions()
            ->where('classwork_id', $classwork->id)
            ->get();
        return view('classworks.show', compact('classroom', 'classwork', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Classroom $classroom, Classwork $classwork)
    {
        // if (!Gate::allows('classworks.update', [$classwork])) {
        //     abort(403);
        // }
        $this->authorize('update', $classwork);

        $type = $classwork->type->value;
        $assigned = $classwork->users()->pluck('id')->toArray();
        return view('classworks.edit', compact('classroom', 'classwork',  'type', 'assigned'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork)
    {
        // if (!Gate::allows('classworks.update', [$classwork])) {
        //     abort(403);
        // }
        $this->authorize('update', $classwork);

        $type = $classwork->type;
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0'],
            'options.due' => [Rule::requiredIf(fn () => $type == 'assignment'), 'date', 'after:published_at'],
        ]);

        $classwork->update($request->all());
        $classwork->users()->sync($request->input('students'));
        return back()->with('success', 'Classwork updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Classwork $classwork)
    {
        $this->authorize('delete', $classwork);
    }
}
