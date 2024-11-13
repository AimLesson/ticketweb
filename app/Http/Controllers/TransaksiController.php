<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::all();
        return view('dashboard', compact('transaksi'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_whatsapp' => 'required|string|max:15',
            'email' => 'required|email',
            'gender' => 'required|in:male,female',
            'nik' => 'required|string|size:16|unique:transaksis',
            'package' => 'required|string',
        ]);

        // Store transaction data
        $transaksi = Transaksi::create($request->all());

        // Create custom WhatsApp message
        $message = 'Proses Pembelian Tiket Be-benz sebesar Rp ' . number_format($request->package, 0, ',', '.') . ' berhasil. Silahkan segera lakukan pembayaran di Be-benz.id/pay';

        // Send WhatsApp notification
        $this->sendWA($request->nomor_whatsapp, $message);

        // Send notification to admin after storing the transaction
        $adminPhoneNumber = '085156106221'; // Replace with the actual admin phone number
        $adminMessage = 'Pemesanan Tiket telah dibuat dengan Nama : ' . $transaksi->nama . ', NIK : '.$transaksi->nik.',No HP : '.$transaksi->nomor_whatsapp.'. ';
        $this->sendWA($adminPhoneNumber, $adminMessage);

        return back()->with('success', 'Link Pembayaran Dikirim melalui WhatsApp');
    }

    private function sendWA($phoneNumber, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $phoneNumber,
                'message' => $message,
                'countryCode' => '62', // for Indonesia
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: 8bsaYrDRaSc2XV7pCmYR', // replace TOKEN with your actual token
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::error('WhatsApp API Error: ' . $error_msg);
        }

        curl_close($curl);

        return $response;
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Process uploaded file
        if ($request->hasFile('picture')) {
            $imageName = $request->file('picture')->store('uploads', 'public');
            return response()->json(['success' => 'Bukti Pembayaran Terkirim! Silahkan Tunggu Notifikasi Tiket via Whatsapp', 'file' => asset('storage/' . $imageName)]);
        }

        return back()->withErrors(['error' => 'Verification failed.']);
    }

    public function verifyTransaction(Request $request)
    {
        $nama = $request->query('nama');
        $nik = $request->query('nik');

        $transaksi = Transaksi::where('nama', $nama)->where('nik', $nik)->first();

        if ($transaksi) {
            return response()->json([
                'success' => true,
                'price' => $transaksi->package,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ]);
        }
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nik' => 'required|string|size:16',
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validating the uploaded file
        ]);
    
        $transaksi = Transaksi::where('nama', $request->nama)
                                ->where('nik', $request->nik)
                                ->first();
    
        if ($transaksi) {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');
    
                $transaksi->picture = $filePath;
                $transaksi->save();
    
                // Send notification to admin (hardcoded admin phone number)
                $adminPhoneNumber = '085156106221'; // Replace with the actual admin phone number
                $message = 'Bukti Pembayaran untuk NIK-'.$transaksi->nik.', diterima, segera verifikasi bukti Pembayaran di be-benz.id/dashboard';
                $this->sendWA($adminPhoneNumber, $message);
    
                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded and saved successfully. Admin notified.',
                ]);
            }
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Failed to verify or save file.',
        ]);
    }
    

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed',
        ]);
    
        $transaksi = Transaksi::find($id);
    
        if ($transaksi) {
            $transaksi->status = $request->status;
            $transaksi->save();
    
            // If the status is 'paid', send WhatsApp confirmation with updated message
            if ($request->status === 'paid') {
                $message = "Pembayaran be-benz sebesar Rp " . number_format($transaksi->package, 0, ',', '.') . " untuk " . $transaksi->nama . " dengan NIK " . $transaksi->nik . " dikonfirmasi. Silahkan Klaim Tiket anda di be-benz.id/claim";
                $this->sendWA($transaksi->nomor_whatsapp, $message);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Transaction status updated successfully.',
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Transaction not found.',
        ]);
    }
    
    

}
