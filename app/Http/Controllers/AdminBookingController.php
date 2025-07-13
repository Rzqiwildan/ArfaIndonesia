<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mobil;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // Halaman admin untuk melihat semua booking
    public function index()
    {
        $bookings = Booking::with('mobil')->orderBy('created_at', 'desc')->get();
        return view('admin.booking', compact('bookings'));
    }

    // API endpoint untuk get semua booking (AJAX)
    public function getBookings()
    {
        try {
            $bookings = Booking::with('mobil')->orderBy('created_at', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $bookings,
                'message' => 'Data berhasil diambil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update status booking
    public function updateStatus(Request $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);
            
            $request->validate([
                'status' => 'required|string|in:pending,confirmed,active,completed,cancelled',
            ]);

            $booking->update([
                'status' => $request->status,
            ]);

            // Jika request AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $booking->load('mobil'),
                    'message' => 'Status booking berhasil diperbarui!'
                ]);
            }

            return redirect()->route('admin.booking.index')
                ->with('success', 'Status booking berhasil diperbarui!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors());
            
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate status: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal mengupdate status!');
        }
    }

    // Delete booking
    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $customerName = $booking->full_name;
            
            $booking->delete();

            // Jika request AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Booking dari ' . $customerName . ' berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.booking.index')
                ->with('success', 'Booking dari ' . $customerName . ' berhasil dihapus!');
                
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus booking: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menghapus booking!');
        }
    }

    // View detail booking
    public function show($id)
    {
        try {
            $booking = Booking::with('mobil')->findOrFail($id);
            
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $booking,
                    'message' => 'Detail booking berhasil diambil'
                ]);
            }

            return view('admin.booking-detail', compact('booking'));
            
        } catch (\Exception $e) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil detail: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Booking tidak ditemukan!');
        }
    }
}