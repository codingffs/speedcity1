<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Degree;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use DB;
use Auth;
use DataTables;
Use File;

class DoctorController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('doctor-list')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        if ($request->ajax()) {
            $User = User::select('*')->where("user_type", "=", 4)->latest();
            return Datatables::of($User)
                    ->addIndexColumn()
                    ->addColumn('created_date', function($row){
                        return date('d-m-Y', strtotime($row->created_at));
                    })
                    ->editcolumn('profile_picture', function($row){
                        $url = url("/images/profile"."/".$row->profile_picture);        
                        return '<img src="'. $url .'" height="80" weight="80"/>';
                    })
                    ->addColumn('action', function($row){
                        $btn = "";
                        $btn .= '<a href="'. route('doctorShow', $row->id) .'" class="edit btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                        if(Auth::user()->can('doctor-edit')){
                            $btn .= '<a href="'. route('doctor.edit', $row->id) .'" class="edit btn btn-primary btn-sm m-1"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                        }
                        if(Auth::user()->can('doctor-delete')){
                            $btn .= '<a href="javascript:void(0)" data-url="'. route('doctor.destroy', $row->id) .'" class="delete_btn btn btn-danger btn-sm" data-id="'. $row->id .'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['created_date','action','profile_picture'])
                    ->make(true);
        }

        return view('admin.doctor.list');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('doctor-create')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $degree = Degree::get();
        $country = Country::get();
        $state = State::get();
        $city = City::get();
        return view('admin.doctor.create',compact('degree','country','state','city'));
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
            if(!Auth::user()->can('doctor-create')){
                return back()->with(['error' => 'Unauthorized Access.']);
            }
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'office_phone_code' => 'required',
                'office_phone' => 'required',
                'profile_picture' => 'required',
                'gender' => 'required',
                'degree' => 'required',
                'specialty' => 'required',
                'practice_start_date' => 'required',
                'birth_date' => 'required',
                'hospital_address_line_1' => 'required',
                'hospital_address_line_2' => 'required',
                'hospital_address_town_city' => 'required',
                'hospital_address_landmark' => 'required',
                'hospital_address_state' => 'required',
                'hospital_address_country' => 'required',
                'hospital_address_pincode' => 'required',
                'doctor_status' => 'required',
                'consultation_fee_at_home' => 'required',
                'registration_number' => 'required',
            ]);

            $password = Str::random(10);
            $hash_password = bcrypt($password);
           
            $profile = rand(0000,9999).$request->profile_picture->getclientoriginalname();
            $request->profile_picture->move(public_path('images/profile'),$profile);
            $doctor_cv = null;
            if(isset($request->doctor_cv) && !empty($request->doctor_cv)){
            $doctor_cv = rand(0000,9999).$request->doctor_cv->getclientoriginalname();
            $request->doctor_cv->move(public_path('images/doctor_cv'),$doctor_cv);
            }

            $degree = implode(',', $request->degree);
            $specialty = implode(',', $request->specialty);
           
            $User = array(
                "name" => $request->name,
                "email" => $request->email,
                "home_phone_code" => $request->home_phone_code,
                "home_phone" => $request->home_phone,
                "office_phone_code" => $request->office_phone_code,
                "office_phone" => $request->office_phone,
                "profile_picture" => $profile,
                "gender" => $request->gender,
                "degree" => $degree,
                "specialty" => $specialty,
                "practice_start_date" => $request->practice_start_date,
                "general_description" => $request->general_description,
                "birth_date" => $request->birth_date,
                "hospital_address_line_1" => $request->hospital_address_line_1,
                "hospital_address_line_2" => $request->hospital_address_line_2,
                "hospital_address_town_city" => $request->hospital_address_town_city,
                "hospital_address_landmark" => $request->hospital_address_landmark,
                "hospital_address_state" => $request->hospital_address_state,
                "hospital_address_country" => $request->hospital_address_country,
                "hospital_address_pincode" => $request->hospital_address_pincode,
                "rating" => $request->rating,
                "doctor_status" => $request->doctor_status,
                "consultation_fee_at_clinic" => $request->consultation_fee_at_clinic,
                "consultation_fee_at_home" => $request->consultation_fee_at_home,
                "registration_number" => $request->registration_number,
                "doctor_cv" => $doctor_cv,
                "user_type" => '4',
            );
            $data_user = User::create($User);
            $User["password"] = $password;
            $email = $request->email;
            \Mail::to($email)->send(new \App\Mail\CreateUserMail($User));
            //$data_user->assignRole([$request->type]);
            return redirect()->route('doctor.index')->with('success','Doctor created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
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
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();
    
        return view('roles.show',compact('role','rolePermissions'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->can('doctor-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $degree_detail = Degree::get(); 
        $User = User::find($id);
        $country = Country::get();
        $state = State::get();
        $city = City::get();
        $degree = explode(",",$User->degree);
        $specialty = explode(",",$User->specialty);
        return view('admin.doctor.edit',compact('User','degree','specialty','degree_detail','country','state','city'));
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
        if(!Auth::user()->can('doctor-edit')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $degree = '';
        $specialty = '';
        
        if(isset($request->degree) && !empty($request->degree)){
            
        $degree = implode(',', $request->degree);
        }
        if(isset($request->specialty) && !empty($request->specialty)){
        $specialty = implode(',', $request->specialty);
        }

        $user = User::find($id);
        $User = array(
            "name" => $request->name,
            "email" => $request->email,
            "home_phone_code" => $request->home_phone_code,
            "home_phone" => $request->home_phone,
            "office_phone_code" => $request->office_phone_code,
            "office_phone" => $request->office_phone,
            "gender" => $request->gender,
            "degree" => $degree,
            "specialty" => $specialty,
            "practice_start_date" => $request->practice_start_date,
            "general_description" => $request->general_description,
            "birth_date" => $request->birth_date,
            "hospital_address_line_1" => $request->hospital_address_line_1,
            "hospital_address_line_2" => $request->hospital_address_line_2,
            "hospital_address_town_city" => $request->hospital_address_town_city,
            "hospital_address_landmark" => $request->hospital_address_landmark,
            "hospital_address_state" => $request->hospital_address_state,
            "hospital_address_country" => $request->hospital_address_country,
            "hospital_address_pincode" => $request->hospital_address_pincode,
            "rating" => $request->rating,
            "doctor_status" => $request->doctor_status,
            "consultation_fee_at_clinic" => $request->consultation_fee_at_clinic,
            "consultation_fee_at_home" => $request->consultation_fee_at_home,
            "registration_number" => $request->registration_number,
        );
        if(isset($request->profile_picture) && !empty($request->profile_picture)){
            if(isset($user->profile_picture) && $user->profile_picture != ""){
            $image_path=public_path('images/profile').'/'.$user->profile_picture;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $profile = rand(0000,9999).$request->profile_picture->getclientoriginalname();
            $request->profile_picture->move(public_path('images/profile'),$profile);
            $User['profile_picture'] = $profile;
        }
        if(isset($request->doctor_cv) && !empty($request->doctor_cv)){
            if(isset($user->doctor_cv) && $user->doctor_cv != ""){
            $image_path=public_path('images/doctor_cv').'/'.$user->doctor_cv;
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            $doctor_cv = rand(0000,9999).$request->doctor_cv->getclientoriginalname();
            $request->doctor_cv->move(public_path('images/doctor_cv'),$doctor_cv);
            $User['doctor_cv'] = $doctor_cv;
        }

        User::whereId($id)->update($User);
    
        return redirect()->route('doctor.index')->with('success','doctor updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->can('doctor-delete')){
            return back()->with(['error' => 'Unauthorized Access.']);
        }
        $user = User::find($id);
        File::delete(public_path('images/profile'. '/'.$user->profile_picture));
        File::delete(public_path('images/doctor_cv'. '/'.$user->doctor_cv));
        if(User::where('id',$id)->delete()){
            return response()->json(["status" => 1]);
        } else {
            return response()->json(["status" => 0]);
        }
    }
    
    public function getStates($id)
    {
        $states = State::where("country_id",$id)->pluck("state_name","state_id");
        return response()->json($states);
    }
   
    public function getCities($id)
    {
        dd(12);
        $cities= City::where("state_id",$id)->pluck("city_name","city_id");
        return response()->json($cities);
    }

    public function doctorShow($id)
    {
        $doctor = User::find($id);
        $degree = explode(",",$doctor->degree);
        return view('admin.doctor.show',compact('doctor','degree'));
    }
}
