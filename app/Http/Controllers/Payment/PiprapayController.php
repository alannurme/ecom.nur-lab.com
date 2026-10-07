<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Models\Order;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use App\Models\Currency;
use App\Http\Controllers\CustomerPackageController;
use App\Http\Controllers\SellerPackageController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CheckoutController;
use Session;

class PiprapayController extends Controller
{
    private function getBaseUrl($customUrl = null)
    {
        $url = $customUrl ?: env('PIPRAPAY_BASE_URL', 'https://pay.nur-lab.com');
        $url = rtrim(trim($url), '/');
        if (str_ends_with($url, '/api')) {
            $url = substr($url, 0, -4);
        }
        return rtrim($url, '/');
    }

    public function pay(Request $request)
    {
        if (!Session::has('payment_type')) {
            flash(translate('Session expired or invalid payment type'))->error();
            return redirect()->route('home');
        }

        $paymentType = Session::get('payment_type');
        $paymentData = Session::get('payment_data');
        $amount = 0;

        if ($paymentType == 'cart_payment') {
            $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
            $amount = $combined_order->grand_total;
        } elseif ($paymentType == 'order_re_payment') {
            $order = Order::findOrFail($paymentData['order_id']);
            $amount = $order->grand_total;
        } elseif ($paymentType == 'wallet_payment') {
            $amount = round($paymentData['amount'], 2);
        } elseif ($paymentType == 'customer_package_payment') {
            $customer_package = CustomerPackage::findOrFail($paymentData['customer_package_id']);
            $amount = round($customer_package->amount, 2);
        } elseif ($paymentType == 'seller_package_payment') {
            $seller_package = SellerPackage::findOrFail($paymentData['seller_package_id']);
            $amount = round($seller_package->amount, 2);
        }

        $user = auth()->user();
        $apiKey = trim(env('PIPRAPAY_API_KEY'));
        $currencyCode = Currency::find(get_setting('system_default_currency'))?->code ?? 'BDT';
        $baseUrl = $this->getBaseUrl();

        $postData = [
            'amount' => (float) $amount,
            'currency' => $currencyCode,
            'full_name' => $user ? $user->name : 'Customer',
            'customer_name' => $user ? $user->name : 'Customer',
            'email_address' => $user ? $user->email : 'customer@nur-lab.com',
            'customer_email' => $user ? $user->email : 'customer@nur-lab.com',
            'mobile_number' => ($user && $user->phone) ? $user->phone : '01700000000',
            'customer_phone' => ($user && $user->phone) ? $user->phone : '01700000000',
            'return_url' => route('piprapay.callback'),
            'redirect_url' => route('piprapay.callback')
        ];

        $ch = curl_init($baseUrl . '/api/checkout/redirect');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'MHS-PIPRAPAY-API-KEY: ' . $apiKey,
            'Authorization: Bearer ' . $apiKey,
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $responseJson = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($responseJson, true);
        $paymentUrl = $response['data']['payment_url'] ?? $response['pp_url'] ?? null;
        $trxId = $response['data']['trx_id'] ?? $response['pp_id'] ?? null;

        if ($paymentUrl) {
            if ($trxId) {
                Session::put('piprapay_trx_id', $trxId);
            }
            return redirect($paymentUrl);
        }

        $errorMsg = $response['error']['message'] ?? $response['message'] ?? translate('Could not generate PipraPay payment URL');
        flash($errorMsg)->error();
        return redirect()->route('home');
    }

    public function callback(Request $request)
    {
        $trx_id = $request->input('trx_id') ?: $request->input('pp_id') ?: Session::get('piprapay_trx_id');

        if (!$trx_id) {
            flash(translate('Transaction ID missing for PipraPay verification'))->error();
            return redirect()->route('home');
        }

        $apiKey = trim(env('PIPRAPAY_API_KEY'));
        $baseUrl = $this->getBaseUrl();

        $ch = curl_init($baseUrl . '/api/verify-payment');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'MHS-PIPRAPAY-API-KEY: ' . $apiKey,
            'Authorization: Bearer ' . $apiKey,
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['trx_id' => $trx_id]));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $responseJson = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($responseJson, true);

        if (isset($response['status']) && $response['status'] == 'success' && isset($response['payment_status']) && strtoupper($response['payment_status']) == 'COMPLETED') {
            $payment_type = Session::get('payment_type');
            $paymentData = Session::get('payment_data');

            if ($payment_type == 'cart_payment') {
                return (new CheckoutController)->checkout_done(Session::get('combined_order_id'), json_encode($response));
            } elseif ($payment_type == 'order_re_payment') {
                return (new CheckoutController)->orderRePaymentDone($paymentData, json_encode($response));
            } elseif ($payment_type == 'wallet_payment') {
                return (new WalletController)->wallet_payment_done($paymentData, json_encode($response));
            } elseif ($payment_type == 'customer_package_payment') {
                return (new CustomerPackageController)->purchase_payment_done($paymentData, json_encode($response));
            } elseif ($payment_type == 'seller_package_payment') {
                return (new SellerPackageController)->purchase_payment_done($paymentData, json_encode($response));
            }
        }

        flash(translate('PipraPay Payment Verification Failed'))->error();
        return redirect()->route('home');
    }

    public function testConnection(Request $request)
    {
        $baseUrl = $this->getBaseUrl($request->input('base_url'));
        $apiKey = trim($request->input('api_key'));

        if (!$baseUrl || !$apiKey) {
            return response()->json([
                'status' => false,
                'message' => translate('Base URL and API Key are required.')
            ]);
        }

        $postData = [
            'amount' => 100.00,
            'currency' => 'BDT',
            'full_name' => 'Test User',
            'customer_name' => 'Test User',
            'email_address' => 'test@nur-lab.com',
            'customer_email' => 'test@nur-lab.com',
            'mobile_number' => '01700000000',
            'customer_phone' => '01700000000',
            'return_url' => route('piprapay.callback'),
            'redirect_url' => route('piprapay.callback')
        ];

        $ch = curl_init($baseUrl . '/api/checkout/redirect');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'MHS-PIPRAPAY-API-KEY: ' . $apiKey,
            'Authorization: Bearer ' . $apiKey,
            'Accept: application/json',
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $responseJson = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return response()->json([
                'status' => false,
                'message' => translate('Connection error: ') . $curlError
            ]);
        }

        $response = json_decode($responseJson, true);

        if (($httpCode == 200 || $httpCode == 201) && (isset($response['status']) && $response['status'] == 'success' || isset($response['pp_url']))) {
            return response()->json([
                'status' => true,
                'message' => translate('Connection Successful! PipraPay API is working correctly.')
            ]);
        }

        $msg = $response['error']['message'] ?? $response['message'] ?? (translate('Connection Failed (HTTP Code: ') . $httpCode . ')');
        return response()->json([
            'status' => false,
            'message' => $msg
        ]);
    }
}
