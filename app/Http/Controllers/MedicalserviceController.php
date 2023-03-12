<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Models\Medicalservice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MedicalserviceController extends Controller
{

    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $medicalservices=Medicalservice::where('isAcceptance','LIKE','waiting')->get();
            return $this->returnData('Medicalservices', $medicalservices);  
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
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
                'typeService' => 'required',
                'note' => 'required',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $typeService = request()->typeService;
            $note = request()->note;
            $isAcceptance='waiting';
            $patient_id=0;
        $user= Auth::guard('user-api')->user();
        $user_id=$user->id;
        $patient=Patient::where('user_id','LIKE',$user_id)->get();
        foreach ($patient as $object)
        {
         $patient_id=$object->id;
        }
        $medicalservice=Medicalservice::create([
            'typeService' =>$typeService,
                'note' =>$note,
                'isAcceptance' =>$isAcceptance,
            'patient_id' =>$patient_id,
           
        ]);
        return $this->returnData('medicalservice', $medicalservice,'medicalservice added successfully');
           
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

    public function acceptance(Request $request,$id)
    {
        try {

            $rules = [
                'descriptionAcceptance' => 'required',
                

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $descriptionAcceptance = request()->descriptionAcceptance;

            $isAcceptance='acceptance';
            $medicalservice=Medicalservice::find($id);
           
            $medicalservice->update([
                'typeService' =>$medicalservice->typeService,
                'note' =>$medicalservice->note,
                'isAcceptance' =>$isAcceptance,
                'descriptionAcceptance'=>$descriptionAcceptance,
            'patient_id' =>$medicalservice->patient_id,
            ]);
            
           return $this->returnSuccessMessage('acceptance successfully');
           
    } catch (\Exception $ex) {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }

    public function unacceptance(Request $request,$id)
    {
        try {

            $rules = [
                'descriptionAcceptance' => 'required',
                

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $descriptionAcceptance = request()->descriptionAcceptance;

            $isAcceptance='Unacceptance';
            $medicalservice=Medicalservice::find($id);
           
            $medicalservice->update([
                'typeService' =>$medicalservice->typeService,
                'note' =>$medicalservice->note,
                'isAcceptance' =>$isAcceptance,
                'descriptionAcceptance'=>$descriptionAcceptance,
            'patient_id' =>$medicalservice->patient_id,
            ]);
            
           return $this->returnSuccessMessage('Unacceptance successfully');
           
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
    public function store(Request $request)
    {
        //
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
