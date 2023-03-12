<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Chronicdiseases;
use App\Models\Doctorcode;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Workingday;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors=Doctor::select()->get();
        return $this->returnData('doctors', $doctors);
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
                'lastName' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phoneNumber' => 'required',
            'description' => 'required',
            'sepecialize' => 'required',
            'language' => 'required',
            'code' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $code = request()->code;
            $existing=Doctorcode::where('code','LIKE',$code)->get();
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
                $firstName = request()->firstName;
                $lastName = request()->lastName;
                $description = request()->description;
                $sepecialize = request()->sepecialize;
                $language = request()->language;
        
                $clinic_id=0;
            
                $clinics=Clinic::select()->get();
                for ($i=0;$i<count($clinics);$i++)
                {
                    if ($clinics[$i]->name ==$sepecialize)
                    {
                        $clinic_id=$clinics[$i]->id;
                        break;
                    }
        
                }
                if($clinic_id==0)
                {
                    return $this->returnError('6666','We apologize, this section is not active for us');
                }
                $status =1;
                $type='doctor';
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'type' => $type,
        
                ]);
                $doctor=Doctor::create([
                    'firstName' =>$firstName,
                        'lastName' =>$lastName,
                    'email' =>$email,
                    'password' =>$password,
                    'phoneNumber' =>$phoneNumber,
                    'description' =>$description,
                    'sepecialize' =>$sepecialize,
                    'language' =>$language,
                    'status' =>$status,
                    'user_id' =>$user->id,
                    'clinic_id' =>$clinic_id,
                ]);
        
        
                $credentials = $request->only(['email', 'password']);
        
                $token = Auth::guard('user-api')->attempt($credentials);
                $user = Auth::guard('user-api')->user();
                $user->api_token = $token;
                //return token
                $Doctor_User=array_merge($user->toArray(),$doctor->toArray());
                return $this->returnData('Doctor_User', $Doctor_User,'Account has been successfully registered');
            }
        
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addWorkingDay(Request $request)
    {
        try {
            $rules = [
                'day' => 'required',
                'hstartTime' => 'required',
                'istartTime' => 'required',
            'hendTime' => 'required',
            'iendTime' => 'required',
            

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $day = date("D",strtotime(request()->day));
            $hstartTime = request()->hstartTime;
            $istartTime = request()->istartTime;
            $hendTime = request()->hendTime;
            $iendTime = request()->iendTime;

            if($hstartTime<10)
          {  $hstartTime='0'.$hstartTime;}

          if($istartTime<10)
          {  $istartTime='0'.$istartTime;}

          if($hendTime<10)
          {  $hendTime='0'.$hendTime;}

          if($iendTime<10)
          {  $iendTime='0'.$iendTime;}
           
   $startTime=date("h:i", strtotime($hstartTime.':'.$istartTime));
  
   $endTime=date("h:i", strtotime($hendTime.':'.$iendTime));

   $now=Carbon::now()->toDateString();
   $dayChek=date("D", strtotime($now));
  
   $timeChek=date("h:i",time());
   $inwork=0;
   $ss=date("D",strtotime('sun'));
   $endTim=date("h:i", strtotime('06:00'));
   //return $timeChek>$startTime;
   if ($day == $dayChek)
   {
       if ($timeChek >= $startimTe && $endTime > $timeChek)
       {
        $inwork=1;
       }
   }
   $user_id=Auth::guard('user-api')->user()->id;
   $doctor=Doctor::where('user_id','LIKE',$user_id)->get();
   $doctor_id=0;
   for ($i=0;$i<count($doctor);$i++)
   {
    $doctor_id=$doctor[$i]->id;

   }
      
   $workday=Workingday::create([
    'day'=>$day,
    'startTime'=>$startTime,
    'endTime'=>$endTime,
    'inWork'=>$inwork,
    'doctor_id'=>$doctor_id,

]);

        return $this->returnData('Working_Day', $workday,'Work day added successfully');
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }
    public function addTags(Request $request)
    {
        try {
            $rules = [
                'check' => 'required',
                'review' => 'required',
                'consultation' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $check= request()->check;
           $review= request()->review;
           $consultation= request()->consultation;
   $user_id=Auth::guard('user-api')->user()->id;
   $doctor=Doctor::where('user_id','LIKE',$user_id)->get();
   $doctor_id=0;
   for ($i=0;$i<count($doctor);$i++)
   {
    $doctor_id=$doctor[$i]->id;

   }
      
   $tags=Tag::create([
    'check'=>$check,
    'review'=>$review,
    'consultation'=>$consultation,
    'doctor_id'=>$doctor_id,

]);

        return $this->returnData('Tags', $tags,'Tags added successfully');
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }


    public function workingDayByDoctor($id)
    {
        try {
            
            $doctor=Doctor::find($id);
           

        return $this->returnData('Tags', $doctor->workingdays,'Tags added successfully');
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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

    public function serch(Request $request)
{
  
      
      
        try {
            $rules = [
                'serch_text' => 'required',
            
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $serch_text=request()->serch_text;
      
            $doctors=Doctor::where('sepecialize','LIKE','%'.$serch_text.'%')->get();
            return $this->returnData('doctors',$doctors);
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }

}

}
