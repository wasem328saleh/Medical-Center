<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Tag;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
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
    public function create(Request $request)
    {
        try {
            $rules = [
                'day' => 'required',
                'dateDay' => 'required',
                'startTime' => 'required',
                'type' => 'required',
                'description' => 'required',
                'doctor_id' => 'required',
                'clinic_id' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $day= date("D",strtotime(request()->day));
           $dateDay= Carbon::parse(request()->dateDay)->toDateString();
           $startTime= date("h:i",strtotime(request()->startTime));
           
           $type= request()->type;
           $description= request()->description;
           $doctor_id=request()->doctor_id;
           $doctor=Doctor::find($doctor_id);

           $clinic_id=request()->clinic_id;
           $user= Auth::guard('user-api')->user();
           $user_id=$user->id;
         
           $patient=Patient::where('user_id','LIKE',$user_id)->get();
           foreach ($patient as $object)
           {
           // return $object->id;

            $patient_id=$object->id;
            $status='waiting';
           $tags=$doctor->tag;
           
           switch($type)
           {
               case "check":
                   {
                       $add=($tags->check)+5;
                       $time=strtotime("+$add minutes",strtotime($startTime));
                       $endTime=date('h:i',$time);

                       $appointment=Appointment::create([
                        'day'=>$day,
                        'dateDay'=>$dateDay,
                        'startTime'=>$startTime,
                        'endTime'=>$endTime,
                        'type'=>$type,
                        'description'=>$description,
                        'status'=>$status,
                        'doctor_id'=>$doctor_id,
                        'patient_id'=>$patient_id,
                        'clinic_id'=>$clinic_id,
                    
                    ]);
                    return $this->returnData('Appointment', $appointment,'Appointment added successfully');
                   }

                   break;
                 case "review":
                   {
                    $add=($tags->review)+5;
                    $time=strtotime("+$add minutes",strtotime($startTime));
                    $endTime=date('h:i',$time);

                    $appointment=Appointment::create([
                     'day'=>$day,
                     'dateDay'=>$dateDay,
                     'startTime'=>$startTime,
                     'endTime'=>$endTime,
                     'type'=>$type,
                     'description'=>$description,
                     'status'=>$status,
                     'doctor_id'=>$doctor_id,
                     'patient_id'=>$patient_id,
                     'clinic_id'=>$clinic_id,
                 
                 ]);
                 return $this->returnData('Appointment', $appointment,'Appointment added successfully');
                   }

                   break;
                 case "consultation":
                   {
                    $add=($tags->consultation)+5;
                    $time=strtotime("+$add minutes",strtotime($startTime));
                    $endTime=date('h:i',$time);

                    $appointment=Appointment::create([
                     'day'=>$day,
                     'dateDay'=>$dateDay,
                     'startTime'=>$startTime,
                     'endTime'=>$endTime,
                     'type'=>$type,
                     'description'=>$description,
                     'status'=>$status,
                     'doctor_id'=>$doctor_id,
                     'patient_id'=>$patient_id,
                     'clinic_id'=>$clinic_id,
                 
                 ]);
                 return $this->returnData('Appointment', $appointment,'Appointment added successfully');
                   }

                   break;
                 default:
                 return $this->returnError('', 'Please send Appointment type');
               }
           
           
         
          
           }
          // return $patient;
          

  



        
    }    catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function freeTimeDoctor(Request $request)
    {
        try {
            $rules = [
                'day' => 'required',
                'doctor_id' => 'required',
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

        $day= request()->day;
$doctor_id= request()->doctor_id;
$appointment=Appointment::where('day','LIKE',$day)->where('doctor_id','LIKE',$doctor_id)->get();

return $this->returnData('Time', $appointment[count($appointment)-2]->endTime,'The Time Free By Doctor .');

           
        
    }    catch (\Exception $ex) {
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
    public function teeeest(Request $request)
{
    

 $validator = Validator::make($request->all(), [
            'image_url' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return $this->returnError(0000, $validator->errors());
        }
        $uploadFolder = 'users';
        $image = $request->file('image_url');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $image=Storage::disk('public')->url($image_uploaded_path);
        return $image;
/*$id = Auth::guard('user-api')->user()->id;
    $user=User::find($id);
    $user->update([
        'image_url'=>$image,
    ]);*/
    return $this->returnSuccessMessage('The image has been added successfully');


}
}
