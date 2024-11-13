<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Str;

class ClaimController extends Controller
{
    public function showClaimForm()
    {
        return view('Home.claim');
    }

    public function verifyClaim(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
        ]);

        // Check if a transaction exists with the given name and NIK
        $transaksi = Transaksi::where('nama', $request->nama)->where('nik', $request->nik)->first();

        if ($transaksi && $transaksi->status === 'paid') {
            if (!$transaksi->qr_code) {
                $randomText = Str::random(10);
                $qrCodeText = "BE-{$transaksi->nik}-{$randomText}";

                // Save the generated QR code text in the transaction
                $transaksi->qr_code = $qrCodeText;
                $transaksi->save();
            } else {
                $qrCodeText = $transaksi->qr_code;
            }

            // Pass the QR code text and the name to the view
            return view('Home.claim', [
                'qrCodeText' => $qrCodeText,
                'qrCodeName' => $transaksi->nama
            ]);
        }

        // Display an error if the transaction is not found or is not paid
        return view('Home.claim', ['errorMessage' => 'Transaction not found or payment not confirmed.']);
    }
}
