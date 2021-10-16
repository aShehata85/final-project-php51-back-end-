<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::all();
        // return $users;
        return view('admin.role.all' , compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.role.create');
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
        // $token = $request->session()->token();
        // $token = csrf_token();
        $data = $request ->all();
        $rules =[
            'name' => ['required' , 'min:4' , 'max:25'],
            
        ];
        $validator = Validator::make($data , $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($data);
        }
        Role::create([
            'name' => $request->name ,
            'email' => $request->email ,
            'password' => Hash::make($request->password) ,
            'remember_token'=> $request->_token ,
        ]);

        // User::create($request->all());
        // return $request;
        // return "Done" ;
         return redirect()->back();
        // return redirect()->route()->'user.index';
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
        // $role = Role::findOrFail($id);
        // return view('admin.role.show' , compact('role'));

        $user = Role::findOrFail($id)->with([
            'user' => function($query){
                $query->select('id' , 'name' , 'role_id');
            }
            // the following showing data related to exact user or admin or moderator
        ])->where('id' , $id)->get();
        return response()->json($user);
        return view('admin.role.show' , compact ('users'));
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
        $role = Role::findOrFail($id);
        return view('admin.role.edit' , compact('role'));
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
        $data = $request ->all();
        $rules =[
            'name' => ['required' , 'min:4' , 'max:25'],
            'email' => ['required' , 'unique:users' , 'email'],
            'password' => ['required' , 'min:8']
        ];
        $validator = Validator::make($data , $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($data);
        }
        $role = Role::findOrFail($id) ;
        $role->update([
            'name' =>$request->name ,
            'email' => $request->email
        ]);
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
        $role = Role::findOrFail($id) ;
        $role->delete();
        return redirect()->back();
    }
}
