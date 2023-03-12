<?php

namespace App\Http\Controllers;

use App\Models\Admincode;
use App\Models\Patientcode;
use App\Models\Doctorcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    use GeneralTrait;
    public function create(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $type = request()->type;
            switch($type)
            {
                case "patient":
                    {
                        a:$code=rand(111111,999999);
                      $existing=Patientcode::where('code','LIKE',$code)->get();
                      if(count($existing) != 0)
                      {
                        goto a;
                      }
                      else 
                      {
                        $patientcode = Patientcode::create([
                            'code' => $code,
                        ]);
                        return $this->returnData('Patient_Code',$code);
                      }
                    }

                    break;
                  case "admin":
                    {
                        b:$code=rand(111111,999999);
                      $existing=Admincode::where('code','LIKE',$code)->get();
                      if(count($existing) != 0)
                      {
                        goto b;
                      }
                      else 
                      {
                        $patientcode = Admincode::create([
                            'code' => $code,
                        ]);
                        return $this->returnData('Admin_Code',$code);
                      }
                    }

                    break;
                  case "doctor":
                    {
                        c:$code=rand(111111,999999);
                      $existing=Doctorcode::where('code','LIKE',$code)->get();
                      if(count($existing) != 0)
                      {
                        goto c;
                      }
                      else 
                      {
                        $patientcode = Doctorcode::create([
                            'code' => $code,
                        ]);
                        return $this->returnData('Doctor_Code',$code);
                      }
                    }

                    break;
                  default:
                  return $this->returnError('', 'Please send user type');
                }
            }

        
         catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function successCode(Request $request)
    {
        try {
            $rules = [
                'type' => 'required',
                'code' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $type = request()->type;
            $code = request()->code;
            switch($type)
            {
                case "patient":
                    {
                        
                      $existing=Patientcode::where('code','LIKE',$code)->get();
                      
                      if(count($existing) == 0)
                      {
                        return $this->returnError('5555','Sorry, it is not on the system');
                      }
                      else 
                      {
                        return $this->returnSuccessMessage('Verified successfully');
                      }
                    }

                    break;
                  case "admin":
                    {
                        
                      $existing=Admincode::where('code','LIKE',$code)->get();
                      if(count($existing) == 0)
                      {
                        return $this->returnError('5555','Sorry, it is not on the system');
                      }
                      else 
                      {
                        return $this->returnSuccessMessage('Verified successfully');
                      }
                    }

                    break;
                  case "doctor":
                    {
                        
                      $existing=Doctorcode::where('code','LIKE',$code)->get();
                      if(count($existing) == 0)
                      {
                        return $this->returnError('5555','Sorry, it is not on the system');
                      }
                      else 
                      {
                        return $this->returnSuccessMessage('Verified successfully');
                      }
                    }

                    break;
                  default:
                  return $this->returnError('', 'Please send user type');
                }
            }

        
         catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    
}
