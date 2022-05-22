<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clientrole;
use Auth;
use Hash;
use Mail;

class ManageUsersController extends Controller
{
    public function index(Request $request) {
        
        // $client = $request->client;
        $sorting_order = $request->sorting_order;
        $sorting_column = $request->sorting_column;
        // print_r($request->all());die;
        $users = User::withCount('finance_list')->where('role','!=', 'Admin')->orderBy('id', 'desc')->paginate(10);     
        if($sorting_order == 'asc'){
            $sortedResult = $users->getCollection()->sortBy($sorting_column, SORT_NATURAL|SORT_FLAG_CASE)->values();
        }else{
            $sortedResult = $users->getCollection()->sortByDesc($sorting_column, SORT_NATURAL|SORT_FLAG_CASE)->values();
        }
        
        $users->setCollection($sortedResult);
            
        return response()->json([
            'success' => true,
            'message' => 'Users list.',
            'users' => $users
        ], 200);
    }

    public function create() {
        //
    }

    public function store(Request $request) {
        
        $request->validate([
            'email' => 'required|email|max:255',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'password' => 'required|confirmed|min:8',
        ]);

        $email = $request->email;

        if(isset($email)){
            if(User::where('email', $email)->count() > 0){
                $errors['email'] = ['Email Already Exists.'];
                return response()->json([
                    'success' => false,
                    'errors' => $errors
                ], 422);
            }
        }

        $user = new User;
        $user->username = $request->fname.' '.$request->lname;
        $user->email = $request->email;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        if($request->avatar != "") {
            $user->profile_picture= $request->avatar;
        }
        $user->password = Hash::make($request->password);
        $user->role = "Client";
        $user->status = $request->status;
        $user->save();
        
        if(isset($request->sendMail) && $request->sendMail == true){
           $mail_sent =  $this->sendMail( $request->all(), 'add');           
           if($mail_sent == true){
                return response()->json([
                    'success' => true,
                    'message' => 'Mail Send successfully.'
                ], 200);
           }
        }
        return response()->json([
            'success' => true,
            'message' => 'User created successfully.'
        ], 200);

    }

    public function show($id) {

        if($id) {
            $user = User::where('id', $id)->first();
                
            return response()->json([
                'success' => true,
                'message' => 'User.',
                'user' => $user
            ], 200);
        }

        return response()->json([
                    'success' => false,
                    'errors' => 'Invalid.'
                ], 401);
    }

    public function edit(Assign $assign) {
        //
    }

    public function update(Request $request, $id) {
        
        
        $request->validate([     
            'email' => 'required|email|max:255',      
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'password' => 'confirmed'
        ]);

        $update_arr = [
            'fname' => $request->fname,
            'lname' => $request->lname,     
            'email' => $request->email,   
            'status' => $request->status        
        ];

        $email = $request->email;

        if(isset($email)){
            if(User::where('email', $email)->whereNotIn('id', [$id])->count() > 0){
                $errors['email'] = ['Email Already Exists.'];
                return response()->json([
                    'success' => false,
                    'errors' => $errors
                ], 422);
            }
        }

        if($request->avatar != "") {
            $update_arr['profile_picture'] = $request->avatar;
        }

        if($request->password != ''){
            $update_arr['password'] = Hash::make($request->password);
        }
        
        User::where('id', $id)->update($update_arr);

        if(isset($request->sendMail) && $request->sendMail == true){
            
            $mail_sent = $this->sendMail($request->all(), 'update');
            
            if($mail_sent == true){
                return response()->json([
                    'success' => true,
                    'message' => 'Mail Send successfully.'
                ], 200);
           }
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.'
        ], 200);
        
    }
    
    public function destroy($id) { 
        if($id) {
            User::where('id', $id)->delete();
            User::where('user_id', $id)->delete();
            return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully.'
            ], 200);
        }

        return response()->json([
                        'success' => false,
                        'errors' => 'Invalid.'
                    ], 401);


    }

    public function uploadFile(Request $request)
    {
        $request->validate([           
            'avatar' => 'mimes:jpg,jpeg,png'
        ]);

        $email = $request->email;

        if(isset($email)){
            if(User::where('email', $email)->count() > 0){
                return response()->json([
                    'success' => false,
                    'errors' => 'Email Already Exists.'
                ], 400);
            }
        }
        $path  = '';
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $imageName = 'user_'.time().'.'.$file->getClientOriginalExtension();
            $uploaded = $file->move(public_path('/uploads'), $imageName);
            $path  = '/uploads/'.$imageName;
        }

        return response()->json([
            'success' => true,
            'path' => $path,
            'message' => 'File uploaded successfully.'
        ], 200);

    }

    public function sendMail($data, $type) {

        $emailData['type'] =  $type;
        $emailData['first_name'] = $data['fname'];
        $emailData['last_name'] = $data['lname'];
        $emailData['email'] = $data['email'];
        if (isset($data['password'])) {
            $emailData['password'] = $data['password'];
        }

        // if($data['client_role'] != ''){
        //     $client_role_data = Clientrole::with('department:id,name')->where('id', $data['client_role'])->first();
        //     $emailData['role'] = $client_role_data->name. '('.$client_role_data->department->name.')';

        // }else{
        //     $emailData['role'] = 'N/A';
        // }
        
        if($type == 'add'){
            $subject = 'Fincance Calcualtor | User Added';         
        }else{
            $subject = 'Fincance Calcualtor | User Updated';
        }

        Mail::send('mail', $emailData, function($message) use($data, $subject) {
            $message->to( $data['email'], 'Fincance Calcualtor')->subject
                ($subject);
            $message->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'));
        });
        
        if( count(Mail::failures()) > 0 ) {                  
            return false;         
        } else {
            return true;       
        }
      
       
    
    }

    public function getUser() {
        $user = User::find(Auth::id());
        return response()->json([
            'success' => true,
            'user' => $user
        ], 201);
    }

    public function updateUser(Request $request) {
        $request->validate([
            'password' => 'confirmed'
        ]);
        
        $user_id = Auth::id();
        $update_user_data = [];
        if(isset($request->fname)){
            $update_user_data['fname'] = $request->fname;
        }
        if(isset($request->lname)){
            $update_user_data['lname'] = $request->lname;
        }
        if (isset($request->avatar)) {
            $update_user_data['profile_picture'] = $request->avatar;
        }
        if (isset($request->password)) {
            $update_user_data['password'] = Hash::make($request->password);
        }
        if (!empty($update_user_data)) {            
            User::updateOrcreate([
                'id' => $user_id
            ],
            $update_user_data);            
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.'
        ], 201);
    }
}
