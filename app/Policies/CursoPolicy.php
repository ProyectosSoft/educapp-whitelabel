<?php

namespace App\Policies;

use App\Models\Curso;
use App\Models\Resena_curso;
use App\Models\User;

class CursoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function matriculado(User $user, Curso $cuorse){
        return $cuorse->students->contains($user->id);
    }

    public function published (?User $user, Curso $cuorse){
        if($cuorse->status==3){
            return true;
        }else{
            return false;
        }
    }

    public function dicatated(User $user,Curso $course){
        if($course->user_id == $user->id){
            return true;
        }else{
            return false;
        }
    }

    public function revision(User $user,Curso $course){
        if($user->hasRole('Administrador')){
            return true;
        }

        if($course->status== 2){
            return true;
        }else{
            return false;
        }
    }

    public function valued(User $user,Curso $course){
        if(Resena_curso::where('user_id',$user->id)->where('curso_id',$course->id)->count()){
            return false;
        }else{
            return true;
        }

    }
}
