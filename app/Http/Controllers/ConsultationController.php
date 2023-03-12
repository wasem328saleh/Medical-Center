<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Consultation;
use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{

    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultation=Consultation::where('Privacy','LIKE','0')->get();
        return $this->returnData('consultation', $consultation);  
    }

    public function indextodoctors()
    {
        $consultation=Consultation::select()->get();
        return $this->returnData('consultation', $consultation);  
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
                'question' => 'required',
                'explain' => 'required',
                'sepecialize' => 'required',
                'Privacy' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $question=request()->question;
            $explain=request()->explain;
            $sepecialize=request()->sepecialize;
            $Privacy=request()->Privacy;
            $clinic_id=0;
            $patient_id=0;
            $clinic=Clinic::where('name','LIKE',$sepecialize)->get();
            foreach ($clinic as $object)
            {
            $clinic_id=$object->id;
            }
            $user= Auth::guard('user-api')->user();
            $user_id=$user->id;
            $patient=Patient::where('user_id','LIKE',$user_id)->get();
            foreach ($patient as $object)
            {
             $patient_id=$object->id;
            }
            $isAnswer=0;
            $now=Carbon::now()->toDateString();
            $consultation=Consultation::create([
                'question'=>$question,
                'dateQuestion'=>$now,
                'explain'=>$explain,
                'Privacy'=>$Privacy,
                'isAnswer'=>$isAnswer,
                'clinic_id'=>$clinic_id,
                'patient_id'=>$patient_id,
            
            ]);
            return $this->returnData('Consultation', $consultation,'Consultation added successfully');
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }
    public function myconsultation()
    {
        try {
        $patient_id=0;
        $user= Auth::guard('user-api')->user();
        $user_id=$user->id;
        $patient=Patient::where('user_id','LIKE',$user_id)->get();
        foreach ($patient as $object)
        {
         $patient_id=$object->id;
        }
        $consultation=Consultation::where('patient_id','LIKE',$patient_id)->get();
        return $this->returnData('consultation', $consultation);   
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
    public function storeAnswer(Request $request,$id)
    {
        try {
            $rules = [
                'answer' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $answer=request()->answer;
            
            $consultation_id=$id;
            $doctor_id=0;
            $doctorname='x';
            $user= Auth::guard('user-api')->user();
            $user_id=$user->id;
            $doctor=Doctor::where('user_id','LIKE',$user_id)->get();
            foreach ($doctor as $object)
            {
             $doctor_id=$object->id;
             $doctorname=$object->firstName.' '.$object->lastName;
             
            }
            $isAnswer=1;
            $consultation=Consultation::find($id);
       
           
                $consultation->update([
                    'question'=>$consultation->question,
                'dateQuestion'=>$consultation->dateQuestion,
                'explain'=>$consultation->explain,
                'Privacy'=>$consultation->Privacy,
                'isAnswer'=>$isAnswer,
                'clinic_id'=>$consultation->clinic_id,
                'patient_id'=>$consultation->patient_id,
                ]);
            
           
            $now=Carbon::now()->toDateString();
            $answer=Answer::create([
                'answer'=>$answer,
                'dateAnswer'=>$now,
                'doctorName'=>$doctorname,
                'doctor_id'=>$doctor_id,
                'consultation_id'=>$id,
            
            ]);
            
            return $this->returnData('consultation', $consultation,'Answer added successfully');
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
     
       

        try {
            
            $consultation=Consultation::find($id);
            $consultation->answers;
            return $this->returnData('consultation', $consultation);
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
