<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mobil;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $mobils = Mobil::all();
        return view('form-booking', compact('mobils'));
    }

    public function submitForm(Request $request)
    {
        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'mobil_id' => 'required|exists:mobils,id',
            'rental_service' => 'required|string|in:Lepas Kunci,Dengan Driver',
            'rental_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:rental_date',
            'delivery_location' => 'nullable|string|max:255',
            'return_location' => 'nullable|string|max:255',
            'delivery_time' => 'nullable',
            'return_time' => 'nullable',
            'special_notes' => 'nullable|string',
        ]);

        // Ambil data mobil yang dipilih
        $mobil = Mobil::find($request->mobil_id);

        // Simpan data booking ke database
        $booking = Booking::create([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'mobil_id' => $request->mobil_id,
            'rental_service' => $request->rental_service,
            'rental_date' => $request->rental_date,
            'return_date' => $request->return_date,
            'delivery_location' => $request->delivery_location,
            'return_location' => $request->return_location,
            'delivery_time' => $request->delivery_time,
            'return_time' => $request->return_time,
            'special_notes' => $request->special_notes,
            'status' => 'pending',
        ]);

        // Buat pesan WhatsApp
        $message = "*FORMULIR PEMESANAN RENTAL MOBIL*\n\n";
        $message .= "*Nama Lengkap:* {$request->full_name}\n";
        $message .= "*No. Handphone:* {$request->phone_number}\n";
        $message .= "*Alamat:* {$request->address}\n";
        $message .= "*Mobil:* {$mobil->name}\n";
        $message .= "*Tipe Transmisi:* {$mobil->type}\n";
        $message .= "*Layanan Sewa:* {$request->rental_service}\n";
        $message .= "*Tanggal Penyewaan:* {$request->rental_date}\n";
        $message .= "*Tanggal Pengembalian:* {$request->return_date}\n";
        
        if ($request->delivery_location) {
            $message .= "*Lokasi Antar:* {$request->delivery_location}\n";
        }
        
        if ($request->return_location) {
            $message .= "*Lokasi Pengembalian:* {$request->return_location}\n";
        }
        
        if ($request->delivery_time) {
            $message .= "*Jam Pengantaran:* {$request->delivery_time}\n";
        }
        
        if ($request->return_time) {
            $message .= "*Jam Pengembalian:* {$request->return_time}\n";
        }
        
        if ($request->special_notes) {
            $message .= "*Catatan Khusus:* {$request->special_notes}\n";
        }
        
        $whatsappUrl = "https://wa.me/6281316413586?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }
}