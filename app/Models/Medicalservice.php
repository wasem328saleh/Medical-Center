<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Medicalservice extends Model implements JWTSubject
{
    use HasFactory;
    protected $table = 'medicalservices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'typeService',
        'note',
        'isAcceptance',
       'patient_id',
       'descriptionAcceptance',
    ];
  
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
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
