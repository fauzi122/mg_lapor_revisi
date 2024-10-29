<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use app\Models\User;
use App\Models\Profil_admin;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
class UserController extends Controller

{
    // public function __construct()
    // {
    //     $this->middleware(['permission:users.index|users.create|users.edit|users.delete']);
    // }

    public function index()
    {
      
        $users = User::where('role', 'ADM')
        ->with(['roles', 'profilAdmin' => function ($query) {
            $query->select('id'); // Hanya ambil kolom 'id' dari profilAdmin
        }])
        ->get();

        return view('user.index', compact('users'));
    }
    
    public function index_bu()
    {
        $user_bu=User::where('role','BU')->get();
        return view('user.index_user_bu',compact('user_bu'));
    }
 
    public function create()
    {

        $jabatan = DB::table('jabatans')->get();
        $roles = Role::where('id','<>','1')->get();
        return view('user.create',compact('roles','jabatan'));
    }

    public function store(Request $request)
    {
        // Validasi input dasar
        $validatedData = $request->validate([
            'username'   => 'required|string|max:20',
            'nik'        => 'required|numeric|digits:16',
            'tingkat'    => 'required|string|max:100',
            'name'       => 'required|string|max:100',
            'id_jabatan' => 'required|string|max:10',
            'tte'        => 'required|string|in:iya,tidak',
            'sso'        => 'required|string|in:non sso,sso',
            'password'   => 'required|string|min:6'
        ]);
    
        // Periksa keunikan email di kedua tabel secara manual
        if (DB::table('profil_admins')->where('email', $request->email)->exists() ||
            DB::table('users')->where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email sudah digunakan di sistem.'])->withInput();
        }
    
        DB::beginTransaction();
        try {
            // Insert ke Profil_admins dan dapatkan ID baru
            $profilAdminId = DB::table('profil_admins')->insertGetId([
                'nip'       => $validatedData['username'],
                'nik'       => $validatedData['nik'],
                'email'     => $request->email,
                'tingkat'   => $validatedData['tingkat'],
                'name'      => $validatedData['name'],
                'id_jabatan'=> $validatedData['id_jabatan'],
                'tte'       => $validatedData['tte'],
                'sso'       => $validatedData['sso'],
                'password'  => bcrypt($validatedData['password']),
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
    
            // Insert ke tabel users dengan referensi profil_adm ke ID Profil_admins
            DB::table('users')->insert([
                'name'      => $validatedData['name'],
                'email'     => $request->email,
                'password'  => bcrypt($validatedData['password']),
                'role'      => 'ADM', 
                'profil_adm'=> $profilAdminId,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
    
            DB::commit();
            return redirect()->route('user.index')->with('sweet_success', 'Data User Berhasil Ditambah!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menambahkan data user: ' . $e->getMessage());
        }
    }
    
    

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $userId = $pecah[0]; // ID dari tabel users
        $profilAdminId = $pecah[1]; // ID dari tabel profil_admins
        
        $user = User::with(['profilAdmin' => function ($query) use ($profilAdminId) {
                $query->where('id', $profilAdminId) // Filter berdasarkan ID di profil_admins
                      ->select('id', 'nip', 'nik', 'tingkat', 'email', 'name', 'id_jabatan', 'tte', 'sso');
            }])
            ->where('id', $userId) // Filter berdasarkan ID di users
            ->first(['id', 'role', 'profil_adm']);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User tidak ditemukan.');
        }
    
        $jabatan = DB::table('jabatans')->get();
        $roles = Role::get();
        $encryptedId = Crypt::encryptString($userId . ',' . $profilAdminId);
        return view('user.edit', compact('user', 'roles', 'jabatan','encryptedId'));
    }
    

    public function update(Request $request)
    {
        $pecah = explode(',', Crypt::decryptString($request->input('encrypted_id')));
    
        $userId = $pecah[0];
        $profilAdminId = $pecah[1];
    
        // Validasi inputan
        $request->validate([
            'nip' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:profil_admins,email,' . $profilAdminId,
            'name' => 'required|string|max:255',
            'nik' => 'required|numeric',
            'tingkat' => 'required|string|max:255',
            'id_jabatan' => 'required|exists:jabatans,id',
            'tte' => 'required|in:iya,tidak',
            'sso' => 'required|in:non sso,sso',
            'password' => 'nullable|min:6',
            'role' => 'required|array', // Pastikan role adalah array
        ]);
    
        DB::beginTransaction();
        try {
            // Ambil instance Profil_admin dan update
            $profilAdmin = Profil_admin::findOrFail($profilAdminId);
            $profilAdmin->nip = $request->nip;
            $profilAdmin->email = $request->email;
            $profilAdmin->name = $request->name;
            $profilAdmin->nik = $request->nik;
            $profilAdmin->tingkat = $request->tingkat;
            $profilAdmin->id_jabatan = $request->id_jabatan;
            $profilAdmin->tte = $request->tte;
            $profilAdmin->sso = $request->sso;
    
            // Update password di profil_admin jika disediakan
            if ($request->filled('password')) {
                $profilAdmin->password = Hash::make($request->password);
            }
    
            $profilAdmin->save();
    
            // Ambil instance User dan update
            $user = User::findOrFail($userId);
            $user->name = $request->name;
            $user->email = $request->email;
    
            // Update password di user jika disediakan
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
    
            $user->save();
    
            // Update roles
            $user->syncRoles($request->input('role'));
    
            DB::commit();
            return redirect('/user')->with('pesan', 'Admin berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memperbarui admin: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        // Dekripsi dan pisahkan ID
        $pecah = explode(',', Crypt::decryptString($id));
        $userId = $pecah[0];
        $profilAdminId = $pecah[1];
    
        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);
            $user->syncRoles([]); // Hapus semua roles
    
            // Hapus data di tabel profil_admins terkait dengan user
            if ($user->profilAdmin) {
                $user->profilAdmin->delete();
            }
    
            // Hapus data di tabel users
            $user->delete();
    
            DB::commit();
            return redirect('/user')->with('sweet_success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    
    
    
}
