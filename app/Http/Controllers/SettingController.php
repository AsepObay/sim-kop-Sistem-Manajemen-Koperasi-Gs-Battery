<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_email' => 'required|email',
            'app_phone' => 'nullable|string|max:50',
            'app_address' => 'nullable|string',
        ]);
        
        return redirect()->route('settings.index')->with('success', 'Settings berhasil disimpan');
    }
}
