<?php

namespace App\Http\Controllers;

use App\Models\EmailMaster;
use Illuminate\Http\Request;

class EmailMasterController extends Controller
{
    public function index() 
    {
        $emails = EmailMaster::orderBy('id', 'asc')->get();
        return view('admin.master.email.index', ['emails' => $emails,]);
    }

    public function edit($id)
    {
        $email = EmailMaster::findOrFail($id);
        
        return view('admin.master.email.edit', [
          'email' => $email
        ]);
    }

    public function update(Request $request, $id)
    {
        $pesan = [
            'subject.required' => 'nama subject masih kosong',
            'content.required' => 'nama content masih kosong',
        ];

        $rules = [
            'subject' => 'required',
            'content' => 'required',
        ];

        $validatedData = $request->validate($rules, $pesan);

        $sanitizedData = fullySanitizeInput($validatedData);

        $update = EmailMaster::where('id', $id)->firstOrFail();
        $update->update($sanitizedData);

        return redirect('/master/email')->with(['success' => 'Data berhasil diupdate']);
    }

}
