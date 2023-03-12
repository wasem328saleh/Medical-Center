<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Doctor extends Model implements JWTSubject
{
    use HasFactory;
    protected $table = 'doctors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'firstName',
        'lastName',
       'phoneNumber',
      'description',
      'sepecialize',
       'language',
        'status',
        'user_id',
        'clinic_id',
    ];
  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
    }
    public function answer()
    {
        return $this->belongsTo(Answer::class, 'doctor_id', 'id');
    }
    public function tag()
    {
        return $this->hasOne(Tag::class, 'doctor_id', 'id');
    }
    public function sessions()
    {
        return $this->hasMany(Session::class, 'doctor_id', 'id');
    }
    public function entryforms()
    {
        return $this->hasMany(Entryform::class, 'doctor_id', 'id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }
    public function workingdays()
    {
        return $this->hasMany(Workingday::class, 'doctor_id', 'id');
    }
    public function holiday()
    {
        return $this->hasMany(Doctorholiday::class, 'doctor_id', 'id');
    }
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'doctor_id', 'id');
    }
   
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    // Rest omitted for brevity
    /** * Get the identifier that will be stored in the subject claim of the JWT.
     * * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /** * Return a key value array, containing any custom claims to be added to the JWT. * * @return array */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
