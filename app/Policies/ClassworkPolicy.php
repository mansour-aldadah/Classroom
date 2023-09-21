<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassworkPolicy
{

    public function before(User $user, $ability)
    {
        if ($user->super_admin) {
            return true;
        }
    }
    public function after(User $user, $ability)
    {
        if ($user->super_admin) {
            return true;
        }
    }


    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Classroom $classroom): bool
    {
        return  $user->classrooms()
            ->wherePivot('classroom_id', $classroom->id)
            ->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Classwork $classwork): bool
    {
        $teacher = $user->classrooms()
            ->wherePivot('classroom_id', $classwork->classroom_id)
            ->wherePivot('role', 'teacher')
            ->exists();
        $assigned = $user->classworks()
            ->wherePivot('classwork_id', $classwork->id)
            ->exists();

        return ($teacher || $assigned);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Classroom $classroom): bool
    {
        $result = $user->classrooms()
            ->withoutGlobalScope(UserClassroomScope::class)
            ->wherePivot('classroom_id', $classroom->id)
            ->wherePivot('role', 'teacher')
            ->exists();
        return $result;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classwork $classwork): bool
    {
        return $classwork->user_id == $user->id && $user->classrooms()
            ->wherePivot('classroom_id', $classwork->classroom_id)
            ->wherePivot('role', 'teacher')
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classwork $classwork): bool
    {
        return $classwork->user_id == $user->id && $user->classrooms()
            ->wherePivot('classroom_id', $classwork->classroom_id)
            ->wherePivot('role', 'teacher')
            ->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Classwork $classwork): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Classwork $classwork): bool
    // {
    //     //
    // }
}
