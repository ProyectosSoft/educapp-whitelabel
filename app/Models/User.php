<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'departamento_id',
        'empresa_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    //Relacion uno a uno
     public function perfil (){
        return $this->hasOne('App\Models\Perfil_usuario');
     }
    //Relacion uno a muchos
    public function cursos_dictado (){
        return $this->hasMany('App\Models\Curso');
     }

     public function Resena_curso(){
        return $this->hasMany('App\Model\Resena_curso');
     }

     public function Comentario(){
        return $this->hasMany('App\Model\Comentario');
     }

     public function Leccion_curso(){
        return $this->hasMany('App\Model\Leccion_curso');
     }
     public function Respuesta_comentario(){
        return $this->hasMany('App\Model\Respuesta_comentario');
     }

     public function Cupon(){
      return $this->hasMany('App\Model\Cupon');
    }

    public function Comentarios(){
        return $this->hasMany('App\Model\Comentarios');
    }

    public function Respuestas_evaluaciones(){
        return $this->hasMany('App\Model\Respuestas_evaluaciones');
    }

    public function Tipo_usuario(){
        return $this->hasMany('App\Model\Tipo_usuario');
    }

    public function Leccioncurso(){
        return $this->hasMany('App\Model\Leccioncurso');
     }

     public function orders(){
        return $this->hasMany('App\Models\Order');
     }


    //Relacion muchos a muchos
    public function cursos_asignado (){
        return $this->belongsToMany('App\Models\Curso');
     }

     public function comprobantesComoPersona()
     {
         return $this->hasMany('App\Models\comprobante_pago');
     }

     public function comprobantesComoUser()
     {
         return $this->hasMany('App\Models\comprobante_pago');
     }



     public function departamento()
     {
         return $this->belongsTo('App\Models\Departamento');
     }

     public function examAttempts()
     {
         return $this->hasMany('App\Models\ExamUserAttempt');
     }

     public function empresa()
     {
         return $this->belongsTo('App\Models\Empresa');
     }
}
