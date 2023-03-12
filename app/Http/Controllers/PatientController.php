<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Patientcode;
use App\Models\Chronicdiseases;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class PatientController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        
        try {
            $rules = [
                'firstName' => 'required|min:3',
                'middeName' => 'required|min:3',
                'lastName' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phoneNumber' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'blood_type' => 'required',
            'length' => 'required',
            'weight' => 'required',
            'berthday' => 'required',
            'code' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $code = request()->code;
            $existing=Patientcode::where('code','LIKE',$code)->get();
                      
                      if(count($existing) == 0)
                      {
                        return $this->returnError('5555','Sorry, it is not on the system');
                      }
                      else 
                      {
                        $name = request()->firstName.'_'.request()->middeName.'_'.request()->lastName;
                        $email = request()->email;
                        $password = request()->password;
                        $phoneNumber = request()->phoneNumber;
                        $firstName = request()->firstName;
                        $middeName = request()->middeName;
                        $lastName = request()->lastName;
                        $address = request()->address;
                        $gender = request()->gender;
                        $blood_type = request()->blood_type;
                        $length = request()->length;
                        $weight = request()->weight;
                        $berthday =Carbon::parse(request()->berthday)->toDateString();
                        $type='patient';
                        $user = User::create([
                            'name' => $name,
                            'email' => $email,
                            'password' => Hash::make($password),
                            'type' => $type,
                
                        ]);
                        $patient=Patient::create([
                            'firstName' =>$firstName,
                                'middeName' =>$middeName,
                                'lastName' =>$lastName,
                            'email' =>$email,
                            'password' =>$password,
                            'phoneNumber' =>$phoneNumber,
                            'address' =>$address,
                            'gender' =>$gender,
                            'blood_type' =>$blood_type,
                            'length' =>$length,
                            'weight' =>$weight,
                            'berthday' =>$berthday,
                            'user_id' =>$user->id,
                        ]);
                
                
                        $credentials = $request->only(['email', 'password']);
                
                        $token = Auth::guard('user-api')->attempt($credentials);
                        $user = Auth::guard('user-api')->user();
                        $user->api_token = $token;
                        //return token
                        $Patient_User=array_merge($user->toArray(),$patient->toArray());
                        return $this->returnData('Patient_User', $Patient_User,'Account has been successfully registered');
                      }
        
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
