<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use App\Models\CombinedOrder;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\SellerPackageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CheckoutController;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PiprapayController extends Controller
{
    public function pay(Request $request)
    {
        $amount = 0;
        if (Session::has('payment_type')) {
            $paymentType = Session::get('payment_type');
            $paymentData = Session::get('payment_data');
            if ($paymentType == 'cart_payment') {
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                $amount = round($combined_order->grand_total);
            } elseif ($paymentType == 'order_re_payment') {
                $order = Order::findOrFail($paymentData['order_id']);
                $amount = round($order->grand_total);
            } elseif ($paymentType == 'wallet_payment') {
                $amount = round($paymentData['amount']);
            } elseif ($paymentType == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail($paymentData['customer_package_id']);
                $amount = round($customer_package->amount);
            } elseif ($paymentType == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail($paymentData['seller_package_id']);
                $amount = round($seller_package->amount);
            }
        }

        $user = Auth::user();
        $name = $user ? $user->name : 'Customer';
        $email = ($user && $user->email) ? $user->email : 'customer@nur-lab.com';

        $api_url = "https://pay.nur-lab.com/api/checkout/redirect";
        $secret_key = env('PIPRAPAY_SECRET_KEY');

        $post_data = [
            'amount'         => (float) $amount,
            'currency'       => 'BDT',
            'customer_name'  => $name,
            'customer_email' => $email,
            'redirect_url'   => route('piprapay.callback')
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $secret_key,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            flash(translate('PipraPay Connection Error: ') . $err)->error();
            return redirect()->route('cart');
        }

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] === 'success' && isset($result['data']['payment_url'])) {
            if (isset($result['data']['trx_id'])) {
                Session::put('piprapay_trx_id', $result['data']['trx_id']);
            }
            return redirect()->away($result['data']['payment_url']);
        }

        $msg = isset($result['message']) ? $result['message'] : translate('Payment initiation failed');
        flash($msg)->error();
        return redirect()->route('cart');
    }

    public function callback(Request $request)
    {
        $trx_id = $request->input('trx_id') ?? Session::get('piprapay_trx_id');

        if (!$trx_id) {
            flash(translate('Invalid PipraPay Transaction ID'))->error();
            return redirect()->route('cart');
        }

        $secret_key = env('PIPRAPAY_SECRET_KEY');
        $verify_url = "https://pay.nur-lab.com/api/verify-payment";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $verify_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['trx_id' => $trx_id]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $secret_key,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['status']) && $result['status'] === 'success' && isset($result['payment_status']) && strtoupper($result['payment_status']) === 'COMPLETED') {
            $payment_type = Session::get('payment_type');
            $paymentData = Session::get('payment_data');

            if ($payment_type == 'cart_payment') {
                if (!auth()->check()) {
                    $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                    auth()->loginUsingId($combined_order->user_id);
                }
                return (new CheckoutController)->checkout_done(Session::get('combined_order_id'), json_encode($result));
            } elseif ($payment_type == 'order_re_payment') {
                return (new CheckoutController)->orderRePaymentDone($paymentData, json_encode($result));
            } elseif ($payment_type == 'wallet_payment') {
                return (new WalletController)->wallet_payment_done($paymentData, json_encode($result));
            } elseif ($payment_type == 'customer_package_payment') {
                return (new CustomerPackageController)->purchase_payment_done($paymentData, json_encode($result));
            } elseif ($payment_type == 'seller_package_payment') {
                return (new SellerPackageController)->purchase_payment_done($paymentData, json_encode($result));
            }
        }

        flash(translate('PipraPay Payment failed or unverified'))->error();
        return redirect()->route('cart');
    }
}
