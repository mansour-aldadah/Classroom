<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);
        $request->merge([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom->id,
        ]);
        $topic = Topic::create($request->all());

        return redirect()->route('classrooms.classworks.index', $classroom->id)->with('success', 'Topic created!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom, Topic $topic)
    {
        $classworks = $topic->classworks()
            ->orderBy('published_at')
            ->get();
        return view('topics.show', [
            'classroom' => $classroom,
            'topic' => $topic,
            'classworks' => $classworks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Topic $topic)
    {
        $request->merge([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom->id,
        ]);
        $topic->update($request->all());
        return redirect()->route('classrooms.classworks.index', $classroom->id)
            ->with('success', 'Topic updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom, Topic $topic)
    {
        $topic->delete();
        return redirect()->route('classrooms.classworks.index', $classroom)->with('success', 'Topic deleted!');
    }
}
