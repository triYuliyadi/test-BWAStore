<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;

use Midtrans\Snap;
use Midtrans\Config;
use PhpParser\Node\Stmt\Foreach_;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Save user data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Process checkout
        $code = 'STORE-' . mt_rand(000000,999999);
            // Memanggil tabel cart
        $carts = Cart::with('product', 'user')
                    ->where('users_id', Auth::user()->id)
                    ->get();
        // Membuat Transaction
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => (int) $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,
        ]);

            //! Membuat transaction detail
        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(000000,999999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }
        // return dd($transaction);

        // Menghapus data cart setelah checkout 
        Cart::where('users_id', Auth::user()->id)->delete();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.mistrans.serverKey');
        Config::$isProduction = config('services.mistrans.isProduction');
        Config::$isSanitized = config('services.mistrans.isSanitized');
        Config::$is3ds = config('services.mistrans.is3ds');

        // Membuat array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'permata_va', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            
                // Redirect to Snap Payment Page
                return redirect($paymentUrl);
            }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request)
    {

    }
}
