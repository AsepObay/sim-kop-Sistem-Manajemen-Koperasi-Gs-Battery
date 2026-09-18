<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use App\Models\LoginBackground;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class LoginBackgroundController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('login_backgrounds')) {
            $backgrounds = collect();
            $active = null;
            return view('admin.settings.login-background', compact('backgrounds', 'active'));
        }

        $backgrounds = LoginBackground::orderByDesc('created_at')->get();
        $active = LoginBackground::where('is_active', true)->first();
        return view('admin.settings.login-background', compact('backgrounds', 'active'));
    }

    public function store(Request $request)
    {
        if (! Schema::hasTable('login_backgrounds')) {
            return redirect()->route('settings.index')->with('error', 'Tabel login_backgrounds belum ada. Jalankan migration terlebih dahulu.');
        }
        Log::info('LoginBackgroundController@store called', ['hasFile' => $request->hasFile('background'), 'type' => $request->input('type')] );

        $request->validate([
            'type' => 'required|in:video,image,default',
            'background' => 'nullable|file',
        ]);

        $type = $request->input('type');

        if ($request->hasFile('background')) {
            $file = $request->file('background');

            // Validate mime and extension
            if ($type === 'video') {
                $request->validate([
                    'background' => 'mimes:mp4,webm|max:51200', // max 50MB
                ]);
            } else {
                $request->validate([
                    'background' => 'image|mimes:jpg,jpeg,png,gif,webp|max:10240',
                ]);
            }

            $path = $file->store('login-backgrounds', 'public');

            // If storing succeeded, create record and optionally activate
            $bg = LoginBackground::create([
                'type' => $type,
                'file_path' => $path,
                'is_active' => $request->boolean('activate', false),
            ]);

            Log::info('LoginBackground stored', ['path' => $path, 'is_active' => $bg->is_active, 'id' => $bg->id]);

            if ($bg->is_active) {
                // deactivate others
                LoginBackground::where('id', '!=', $bg->id)->update(['is_active' => false]);
            }

            return redirect()->route('settings.login_background.index')->with('success', 'Background berhasil diunggah.');
        }

        // If no file but type change
        if ($type === 'default') {
            // deactivate all
            LoginBackground::where('is_active', true)->update(['is_active' => false]);
            // create a default entry
            LoginBackground::create(['type' => 'default', 'file_path' => null, 'is_active' => true]);
            LoginBackground::where('id', '!=', LoginBackground::latest('id')->first()->id)->update(['is_active' => false]);
        }

        return redirect()->route('settings.login_background.index')->with('success', 'Pengaturan background disimpan.');
    }

    public function activate(LoginBackground $loginBackground)
    {
        if (! Schema::hasTable('login_backgrounds')) {
            return redirect()->route('settings.index')->with('error', 'Tabel login_backgrounds belum ada. Jalankan migration terlebih dahulu.');
        }
        // activate selected and deactivate others
        LoginBackground::query()->update(['is_active' => false]);
        $loginBackground->is_active = true;
        $loginBackground->save();

        return redirect()->route('settings.login_background.index')->with('success', 'Background diaktifkan.');
    }

    public function destroy(LoginBackground $loginBackground)
    {
        if (! Schema::hasTable('login_backgrounds')) {
            return redirect()->route('settings.index')->with('error', 'Tabel login_backgrounds belum ada. Jalankan migration terlebih dahulu.');
        }
        if ($loginBackground->file_path) {
            Storage::disk('public')->delete($loginBackground->file_path);
        }

        $wasActive = $loginBackground->is_active;
        $loginBackground->delete();

        if ($wasActive) {
            // ensure no active remains; leave default behavior
            LoginBackground::where('is_active', true)->update(['is_active' => false]);
        }

        return redirect()->route('settings.login_background.index')->with('success', 'Background berhasil dihapus.');
    }
}
