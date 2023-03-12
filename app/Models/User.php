<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Product;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function patient()
    {
        return $this->hasMany(Patient::class,'user_id','id');
    }
    public function doctor()
    {
        return $this->hasMany(Doctor::class, 'user_id', 'id');
    }
    public function admin()
    {
        return $this->hasMany(Admin::class, 'user_id', 'id');
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // Rest omitted for brevity 
/** * Get the identifier that will be stored in the subject claim of the JWT. 
* * @return mixed 
*/ 
public function getJWTIdentifier() 
{ 
return $this->getKey(); 
} 
/** * Return a key value array, containing any custom claims to be added to the JWT. * * @return array */ 
public function getJWTCustomClaims() { return []; }
}
