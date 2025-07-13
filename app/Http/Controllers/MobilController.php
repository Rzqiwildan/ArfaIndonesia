<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::all();
        return view('admin.mobil', compact('mobils'));
    }

    // API endpoint untuk get semua mobil (AJAX)
    public function getMobils()
    {
        try {
            $mobils = Mobil::orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $mobils,
                'message' => 'Data berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255|unique:mobils,name',
            'type' => 'required|string|in:Manual,Matic',
            'stok' => 'required|integer|min:0',
        ]);

        $mobil = Mobil::create([
            'name' => $request->name,
            'type' => $request->type,
            'stok' => $request->stok,
        ]);

        return response()->json([
            'success' => true,
            'data' => $mobil,
            'message' => 'Mobil berhasil ditambahkan!'
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menambahkan mobil: ' . $e->getMessage()
        ], 500);
    }
}

    
    public function update(Request $request, $id)
    {
        try {
            $mobil = Mobil::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255|unique:mobils,name,' . $id,
                'type' => 'required|string|in:Manual,Matic',
                'stok' => 'required|integer|min:0',
            ]);

            $mobil->update([
                'name' => $request->name,
                'type' => $request->type,
                'stok' => $request->stok,
            ]);

            // Jika request AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $mobil,
                    'message' => 'Mobil ' . $mobil->name . ' berhasil diperbarui!'
                ]);
            }

            return redirect()->route('mobil.index')
                ->with('success', 'Mobil ' . $mobil->name . ' berhasil diperbarui!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate mobil: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal mengupdate mobil!');
        }
    }

    public function destroy($id)
    {
        try {
            $mobil = Mobil::findOrFail($id);
            $mobilName = $mobil->name;
            
            $mobil->delete();

            // Jika request AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mobil ' . $mobilName . ' berhasil dihapus!'
                ]);
            }

            return redirect()->route('mobil.index')
                ->with('success', 'Mobil ' . $mobilName . ' berhasil dihapus!');
                
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus mobil: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menghapus mobil!');
        }
    }
}