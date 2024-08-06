<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    const HASH_SECRET = 'HPVTMFHUSSKWMZQGSDFKDDPUTZBUOPPJ';
    public function checkout($id)
    {
        $bill = Bill::find($id);
        // dd($bill);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('public.checkout.result');
        $vnp_TmnCode = "GB9GXK63"; //Mã website tại VNPAY 
        $vnp_HashSecret = self::HASH_SECRET; //Chuỗi bí mật

        $vnp_TxnRef = $id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toan hoa don phi dich vu";
        $vnp_OrderType = 'bill';
        $vnp_Amount = 25000 * 100 * $bill->total_price;
        $vnp_Locale = 'vn';
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            switch ($i) {
                case 1:
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    break;
                default:
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                    break;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =  hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= "vnp_SecureHash=$vnpSecureHash";
        }
        return redirect($vnp_Url);
    }

    public function result()
    {
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        // Khóa bí mật từ VNPAY
        $vnp_HashSecret = self::HASH_SECRET;

        // Mã hóa dữ liệu
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Kiểm tra chữ ký
        if ($secureHash === $vnp_SecureHash) {
            $vnp_TransactionStatus = $inputData['vnp_TransactionStatus'];
            $vnp_TxnRef = $inputData['vnp_TxnRef'];
            $mailController = new MailController();

            if ($vnp_TransactionStatus == 00) {
                // Cập nhật trạng thái đơn hàng
                $bill = Bill::find($vnp_TxnRef);
                $bill->is_paid = 1;
                $bill->save();
                $mailController->send($vnp_TxnRef);
                return redirect()->route('public.cart')->with('success', 'Payment success');
            }
        }
        $mailController->send($vnp_TxnRef);
        return redirect()->route('public.cart')->with('error', 'Payment failed');
    }
}
