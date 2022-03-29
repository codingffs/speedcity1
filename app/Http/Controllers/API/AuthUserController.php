<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use App\User_detail;
use App\Company_detail;
use App\Countries;
use App\States;
use App\Cities;
use App\Occupation;
use App\Models\UserauthModel;
use App\Survey_groups;
use App\Survey_participant;
use App\Demo_survey_groups;
use App\Demo_survey_participant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Mail;
use Illuminate\Support\Facades\Storage;
class AuthUserController extends BaseController {
    public function __construct(UserauthModel $UserauthModel) {
        $this->UserauthModel = $UserauthModel;
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) {        
        
        $customMessages  = [
            'regex:/[a-z]/'=>"Must have atleast one lower case charecter.",
            'regex:/[A-Z]/'=>"Must have atleast one upper case charecter.",
            'regex:/[0-9]/'=>"Must have atleast one number.",
            'regex:/[@$!%*#?&]/'=>"Must have atleast one special charecter.",
        ];
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'phone' => 'required',
                    'address_line_1' => 'required',
                    'city' => '',
                    'state' => 'required',
                    'zip' => ['required','min:5','max:7'],
                    'email' => 'required|email',
                    'password' => ['required','string','min:6','max:50'],
                    'confirm_password' => 'required|same:password',
                    'agreeTerms' => 'required',
                    'agreePrivacy' => 'required',
        ],$customMessages);
        
        $attributeNames = array(
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'address_line_1' => 'Address Line 1',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'agreeTerms' => 'Agree to Terms & Conditions',
            'agreePrivacy' => 'Agree to Privacy Policy',
        );
        $validator->setAttributeNames($attributeNames);
        
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        
        $user = $this->UserauthModel->getUserByEmail($input['email']);
        
        if ($user) {
            return $this->sendError('User alreardy registered.',[]);
        }        

        $email_verify_code = $this->generateForgotKey($input['email']);        
        
        $maildata = array(
            'email_verification_code' => $email_verify_code
        );
        
        $userData = array(
            'name'=>$input['first_name'].' '.$input['last_name'],
            'email'=>$input['email'],
            'password'=>bcrypt($input['password']),
            'role'=>2,
            'email_verification_code'=>$email_verify_code
        );
        
        $user = User::create($userData);
                        
        if (isset($user)) {
            
            $userDetail = array(
                'user_id'=>$user->id,    
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                'email'=>$input['email'],
                'title'=>$input['title'],
                'cv'=>$input['cv'],
                'sector'=>$input['sector'],
                'occupation'=>$input['occupation'],
                'phone'=>$input['phone'],
                'address_line_1'=>$input['address_line_1'],
                'address_line_2'=>$input['address_line_2'],
                'city'=>$input['city'],
                'state'=>$input['state'],
                'country'=>$input['country'],
                'zip'=>$input['zip'],
                'created_at'=>date('Y-m-d'),
                'updated_at'=>date('Y-m-d'),
            );
            
            DB::table('user_details')->insert($userDetail);
            
            $userDetail2 = array(
                'id'=>$user->id,    
                'firstname'=>$input['first_name'],
                'lastname'=>$input['last_name'],
                'email'=>$input['email'],
                'title'=>$input['title'],
                'phone'=>$input['phone'],
                'address1'=>$input['address_line_1'],
                'address2'=>$input['address_line_2'],
                'city'=>$input['city'],
                'state'=>$input['state'],
                'zip'=>$input['zip'],
            );
            
            DB::table('profiles')->insert($userDetail2);
            
            $success['name'] = $user->name;
            $mailuse = array(
                'email' => $user->email,
                'name' => $user->name
            );

            $mail = Mail::send('user/verification_email', $maildata, function($message) use ($mailuse) {
                        $message->to($mailuse['email'], $mailuse['name'])->subject('TeamPlayerHR - Please verify your email address.');
                        $message->from('info@teamplayerhr.com', 'TeamPlayerHR');
                    });
            if($input['cv'] != '')
            {
                $this->addDemoGroup($user->id,$input);
            }
            return $this->sendResponse($success, 'User register successfully, Please verify your email.');
        } else {
            return $this->sendResponse(array(), 'User alreardy registered.');
        }
    }
    
    private function addDemoGroup($user_id,$user=""){
        $dataGroup = array(
                            'name'=>$user['first_name'].' '.$user['last_name']." Group",
                            'code'=>"1234",
                            'max_size'=>"2",
                            'test'=>"2"
                            );
        $survey_group = Demo_survey_groups::create($dataGroup);
        $joiningDate = date("Y-m-d");
        $expieryDate = date('Y-m-d', strtotime($joiningDate. ' + 1 year'));            
            
        $dataParticipant = array(
                            'profile_id'=>$user_id,
                            'access'=>"A",
                            'survey_group_id'=>$survey_group->id,
                            'created_at'=>$joiningDate,
                            'updated_at'=>$joiningDate,
                            'exptre_at'=>$expieryDate,
                            );
        $participant = Demo_survey_participant::create($dataParticipant);
    }
    
    public function registerOrg(Request $request) {        
        
        $validator = Validator::make($request->all(), [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'organization_name' => 'required',
                    'phone' => 'required',
                    'address_line_1' => 'required',
                    'city' => '',
                    'state' => 'required',
                    'zip' => ['required','min:5','max:7'],
                    'email' => 'required|email',
                    'password' => ['required','string','min:6','max:50'],
                    'confirm_password' => 'required|same:password',
                    'agreeTerms' => 'required',
                    'agreePrivacy' => 'required',
        ]);
        
        $attributeNames = array(
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'organization_name' => 'Organization Name',
            'user_role' => 'Your Role',
            'no_of_employees' => 'No Of employees',
            'phone' => 'Phone',
            'address_line_1' => 'Address Line 1',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'agreeTerms' => 'Agree to Terms & Conditions',
            'agreePrivacy' => 'Agree to Privacy Policy',
        );
        $validator->setAttributeNames($attributeNames);
        
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        
        $user = $this->UserauthModel->getUserByEmail($input['email']);
        
        if ($user) {
            return $this->sendError(array(), 'User alreardy registered.');
        }        

        $email_verify_code = $this->generateForgotKey($input['email']);        
        
        $maildata = array(
            'email_verification_code' => $email_verify_code
        );
        
        $userData = array(
            'name'=>$input['first_name'].' '.$input['last_name'],
            'email'=>$input['email'],
            'password'=>bcrypt($input['password']),
            'role'=>3,
            'email_verification_code'=>$email_verify_code
        );
        
        $user = User::create($userData);
                        
        if (isset($user)) {
            $userDetail = array(
                'user_id'=>$user->id,    
                'first_name'=>$input['first_name'],
                'last_name'=>$input['last_name'],
                'email'=>$input['email'],
                'title'=>$input['title'],
                'organization_name'=>$input['organization_name'],
                'user_role'=>$input['user_role'],
                'no_of_employees'=>$input['no_of_employees'],
                'phone'=>$input['phone'],
                'address_line_1'=>$input['address_line_1'],
                'address_line_2'=>$input['address_line_2'],
                'sector'=>$input['sector'],
                'city'=>$input['city'],
                'state'=>$input['state'],
                'country'=>$input['country'],
                'zip'=>$input['zip'],
                'created_at'=>date('Y-m-d'),
                'updated_at'=>date('Y-m-d'),
            );
            
            User_detail::create($userDetail);
            
            $companyDetail = array(
                'user_id'=>$user->id,    
                'email'=>$input['email'],
                'organization_name'=>$input['organization_name'],
                'user_role'=>$input['user_role'],
                'no_of_employees'=>$input['no_of_employees'],
                'phone'=>$input['phone'],
                'address_line_1'=>$input['address_line_1'],
                'address_line_2'=>$input['address_line_2'],
                'sector'=>$input['sector'],
                'city'=>$input['city'],
                'state'=>$input['state'],
                'country'=>$input['country'],
                'zip'=>$input['zip']
            );
            
            $company = Company_detail::create($companyDetail);
                                    
            $success['name'] = $user->name;
            $mailuse = array(
                'email' => $user->email,
                'name' => $user->name
            );

            $mail = Mail::send('user/verification_email', $maildata, function($message) use ($mailuse) {
                        $message->to($mailuse['email'], $mailuse['name'])->subject('Team Player HR - Please verify your email address.');
                        $message->from('info@teamplayerhr.com', 'Team Player HR');
                    });
            $this->addOrgGroup($user->id,$userDetail,$company);        
            
            return $this->sendResponse($success, 'User register successfully, Please verify your email.');
        } else {
            return $this->sendResponse(array(), 'User alreardy registered.');
        }
    }
    
    private function addOrgGroup($user_id,$user="",$company=""){
        $dataGroup = array(
                            'name'=>$user['organization_name']." Group",
                            'code'=>"1234",
                            'max_size'=>"0",
                            'test'=>"2",
                            'company_id'=>$company->id
                            );
        $survey_group = Survey_groups::create($dataGroup);
        $joiningDate = date("Y-m-d");
        $expieryDate = date('Y-m-d', strtotime($joiningDate. ' + 1 year'));            
            
        $dataParticipant = array(
                            'profile_id'=>$user_id,
                            'access'=>"A",
                            'survey_group_id'=>$survey_group->id,
                            'created_at'=>$joiningDate,
                            'updated_at'=>$joiningDate,
                            'exptre_at'=>$expieryDate,
                            );
        $participant = Survey_participant::insert($dataParticipant);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            $success['token'] = "Bearer " . $user->createToken('App')->accessToken;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['role'] = $user->role; 
            
            if($user->email_verified == 0)
            {
                return $this->sendError('Unauthorised.', ['error' => 'Please verify your email.']);
            }
            else if($user->active == 0)
            {
                return $this->sendError('Unauthorised.', ['error' => 'Your account is deactivated, please contact admin.']);
            }
            else
            {
                return $this->sendResponse($success, 'User login successfully.');
            }
        } else {
            return $this->sendError('Invalid Login Credentials.', ['error' => 'Unauthorised']);
        }
    }
    
    public function loginSocial(Request $request) {
        $input = $request->all();
        $res = $this->UserauthModel->getUserByEmail($input['email']);
        if ($res) {
            $user = Auth::loginUsingId($res->id);
            $success['token'] = "Bearer " . $user->createToken('App')->accessToken;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            
            if($user->email_verified == 0)
            {
                return $this->sendError('Unauthorised.', ['error' => 'Please verify your email.']);
            }
            else
            {
                return $this->sendResponse($success, 'User login successfully.');
            }
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($this->generateRandomString(12));
            $input['role'] = 2;
            $user = User::create($input);
            
            $success['token'] = "Bearer " . $user->createToken('App')->accessToken;
            $success['email_verified'] = 1;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            return $this->sendResponse($success, 'User login successfully.');
        }
    }

    /**
     * Forgot Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgot(Request $request) {
        $validator = Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email', 'max:255']
        ]);

        if ($validator->fails()) {

            $this->error = $validator->errors()->messages();

            return $this->sendError('error', $this->error,400);
        }

        $input = $request->all();
        
        $user = $this->UserauthModel->getUserByEmail($input['email']);
        
        if ($user) {
            $key = $this->generateForgotKey($user->email);

            $this->UserauthModel::where('id', $user->id)
                    ->update(['forgotten_password_code' => $key, 'forgotten_password_time' => time() + 600]);


            $maildata = array('key' => $key);

            $mail = Mail::send('user/forget_password_mail', $maildata, function($message) use ($user) {
                        $message->to($user->email, $user->name)->subject('TeamPlayerHr - Forgot Password');
                        $message->from('info@teamplayerhr.com', 'TeamPlayerHr');
                    });
            $success['email'] =  $user->email;       
            return $this->sendResponse($success, 'Reset password link send to your email.');
        }

        return $this->sendError('error', "Invalid email.",400);
    }

    protected function generateForgotKey($email = false) {
        $activation_code_part = "";

        if (!$email) {
            return $activation_code_part;
        }

        if (function_exists("openssl_random_pseudo_bytes")) {
            $activation_code_part = openssl_random_pseudo_bytes(128);
        }

        for ($i = 0; $i < 1024; $i++) {
            $activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
        }

        $key = Hash::make($activation_code_part . $email);

        return str_replace(array('+', '/', '='), array('-', '_', '~'), $key);
    }

    protected function generateRandomString($length = 4) {
        if (!$length) {
            return false;
        }

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
    
    public function country(){
        $data = Countries::orderBy('name')->get();    
        
        for($i = 0; $i < count($data);$i++)
        {
            $data[$i]->text = $data[$i]->name;
        }
        
        return $this->sendResponse($data, 'Countries retrieved successfully.');
    }
    public function state(Request $request){
        $country_id = $request->input('country_id');
        $data = States::where('country_id',$country_id)->orderBy('name')->get();  
        for($i = 0; $i < count($data);$i++)
        {
            $data[$i]->text = $data[$i]->name;
        }
        return $this->sendResponse($data, 'States retrieved successfully.');
    }
    public function city(Request $request){
        $state_id = $request->input('state_id');
        $data = Cities::where('state_id',$state_id)->orderBy('name')->get();    
        for($i = 0; $i < count($data);$i++)
        {
            $data[$i]->text = $data[$i]->name;
        }
        return $this->sendResponse($data, 'Cities retrieved successfully.');
    }
    public function occupation(Request $request){
        $data = Occupation::orderBy('name')->get();    
        for($i = 0; $i < count($data);$i++)
        {
            $data[$i]->text = $data[$i]->name;
        }
        return $this->sendResponse($data, 'Occupation retrieved successfully.');
    }
    
    public function upload(Request $request) {
        //print_r($_FILES);die;
        $validator = Validator::make($request->all(), [
            'file' => ['required']
        ]);

        if ($validator->fails()) {
            $this->error = $validator->errors()->messages();
            return $this->sendError('Validation Error.', $this->error);  
        }

        if ($request->hasfile('file')) {
            $path = Storage::putFile('public/', $request->file('file'));
            return $this->sendResponse(['filename' => basename($path)], 'File successfully uploaded.');
            
        }
        return $this->sendError('Somthing went wrong.', $this->error); 
    } 


}
