<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Admin;
use App\Models\Admincode;
use App\Models\Chronicdiseases;
use App\Models\Clinic;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'firstName' => 'required|min:3',
                'lastName' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phoneNumber' => 'required',
            'code' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $code = request()->code;
            $existing=Admincode::where('code','LIKE',$code)->get();
                      if(count($existing) == 0)
                      {
                        return $this->returnError('5555','Sorry, it is not on the system');
                      }
                      else 
                      {
                        $name = request()->firstName.'_'.request()->lastName;
                        $email = request()->email;
                        $password = request()->password;
                        $phoneNumber = request()->phoneNumber;
                        $type='admin';
                        $user = User::create([
                            'name' => $name,
                            'email' => $email,
                            'password' => Hash::make($password),
                            'type' => $type,
                
                        ]);
                        $admin=Admin::create([
                            'name'=>$name,
                            'phoneNumber' =>$phoneNumber,
                            'user_id' =>$user->id,
                        ]);
                
                
                        $credentials = $request->only(['email', 'password']);
                
                        $token = Auth::guard('user-api')->attempt($credentials);
                        $user = Auth::guard('user-api')->user();
                        $user->api_token = $token;
                        //return token
                        $Admin_User=array_merge($user->toArray(),$admin->toArray());
                        return $this->returnData('Admin_User', $Admin_User,'Account has been successfully registered');
                      }
        $name = request()->firstName.'_'.request()->lastName;
        $email = request()->email;
        $password = request()->password;
        $phoneNumber = request()->phoneNumber;
        $type='admin';
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'type' => $type,

        ]);
        $admin=Admin::create([
            'name'=>$name,
            'phoneNumber' =>$phoneNumber,
            'user_id' =>$user->id,
        ]);


        $credentials = $request->only(['email', 'password']);

        $token = Auth::guard('user-api')->attempt($credentials);
        $user = Auth::guard('user-api')->user();
        $user->api_token = $token;
        //return token
        $Admin_User=array_merge($user->toArray(),$admin->toArray());
        return $this->returnData('Admin_User', $Admin_User,'Account has been successfully registered');
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
