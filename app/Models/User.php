<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fecha_ingreso',
        'punto',
        'rol',
        'estatus',
        'empresa',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function solicitudBajas() {
        return $this->hasMany(SolicitudBajas::class);
    }
    public function documentacionAltas(){
        return $this->hasOne(DocumentacionAltas::class, 'id', 'sol_docs_id');
    }
    public function solicitudAlta()
    {
        return $this->hasOne(SolicitudAlta::class, 'id', 'sol_alta_id');
    }

    public function solicitarVacacionesForm(){
        return view('user.solicitarVacacionesForm');
    }

    public function subpunto()
    {
        return $this->belongsTo(Subpunto::class);
    }

    public function subpuntosSupervisados()
    {
        return $this->belongsToMany(Subpunto::class, 'supervisorpuntos', 'supervisor_id', 'subpunto_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
