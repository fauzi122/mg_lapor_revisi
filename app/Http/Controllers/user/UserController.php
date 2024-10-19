<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use app\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:users.index|users.create|users.edit|users.delete']);
    // }

    public function index()
    {
        $users = User::where('role', 'ADM')
        ->with('roles') // Eager load roles
        ->get();

        return view('user.index', compact('users'));
    }
    
    public function index_bu()
    {
        $user_bu=User::where('role','BU')->get();
        return view('user.index_user_bu',compact('user_bu'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::latest()->get();
        $roles = Role::where('id','<>','1')->get();
        return view('user.create',compact('roles'));
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
    public function edit(User $user)
    {
        $roles = Role::get();
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required'
        ]);

        $user = User::findOrFail($user->id);

        if ($request->input('password') == "") {
            $user->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email')
               
            ]);
        } else {
            $user->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'password'  => bcrypt($request->input('password'))
                

            ]);
        }

        //assign role
        $user->syncRoles($request->input('role'));

        if ($user) {
            //redirect dengan pesan sukses
            return redirect('/data-user/adm')->with('sweet_success','Data Berhasil Ditambah');
        }
            else{
                return redirect('/data-user/adm')->with('sweet_error','Gagal Ditambah');
            }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $cek= User::where([
            'id'       =>$user->id
            ])->first();
        User::destroy($user->id);
        return redirect('/data-user/adm')->with('sweet_success','Data Berhasil Dihapus');
  
    }
}
