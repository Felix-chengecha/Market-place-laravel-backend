<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class PaymentController extends Controller
{
    public function lipanampesapassword()
    {
        $timestamp = Carbon::rawParse('now')->format('YmdHis');
        $shortcode = 174379;
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $lipampesapassword = base64_encode($shortcode . $passkey . $timestamp);
        return $lipampesapassword;
    }

    public function newAccessToken()
    {
        // $secret= config('items.consumer_secret.consumer_secret');
        // $key= config('items.consumer_key.consumer_key');


        $consumer_key="jabCSvWlEGwr2G2E1RUPXrGLEaglXsuw";
        $consumer_secret="dM2znrtDCMKVYhGU";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials,"Content-Type:application/json"));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        curl_close($curl);

        return $access_token->access_token;
    }


    public function paydetails(Request $request)
    {
        $amount = $request->amount;
        $phone = $request->phone;
        $data = [
            'BusinessShortCode' => 174379,
            'Password' => $this->lipanampesapassword(),
            'Timestamp' => "20230121223234",
            'TransactionType' => "CustomerPayBillOnline",
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => 174379,
            'PhoneNumber' => $phone,
            'CallBackURL' => "https://mydomain.com/path",
            'AccountReference' => "Heroic marketplace",
            'TransactionDesc' => "my shopping cart"
        ];

        $info = json_encode($data);

        return $info;
    }

    public function payment(Request $request)    {

        $consumer_key="jabCSvWlEGwr2G2E1RUPXrGLEaglXsuw";
        $consumer_secret="dM2znrtDCMKVYhGU";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);

        $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->newAccessToken()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->paydetails($request));
        $curl_response = curl_exec($curl);
        // return redirect('/confirm');


        $backinfo = json_decode($curl_response, true);


        try {
            $resp = $backinfo['ResponseCode'];
            $CM = $backinfo['CustomerMessage'];

            if ($resp == '0') {

                return response()->json([
                    'res' => "transaction queued for processing"
                ]);
            } else {
                return response()->json(["transaction failed try again"]);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            echo $curl_response;
        }
    }

    public function savecart(Request $request){
        $user = Auth::user();
        $userid=$user->id;

        $cart=new Cart;

        $cart->items=$request->items;
        $cart->user_id=$userid;
        $cart->save();
        return response()->json([
         'msg'=> "transaction successfully completed"
        ]);

    }


    public function saveTransaction(Request $request ) {
                $cart_id=$request->cart_id;
                $user_id = Auth::user()->id;
        $response = json_decode($request->getContent());
        $resData =  $response->Body->stkCallback->CallbackMetadata;
        $reCode =$response->Body->stkCallback->ResultCode;
        $resMessage =$response->Body->stkCallback->ResultDesc;
        $amountPaid = $resData->Item[0]->Value;
        $mpesaTransactionId = $resData->Item[1]->Value;
        $paymentPhoneNumber =$resData->Item[4]->Value;
        $formatedPhone = str_replace("254","0",$paymentPhoneNumber);

        if($reCode=='1') {
            $this->savecart($request);

        $Trans = new Transactions;
            $Trans->cart_id = $cart_id;
            $Trans->total =  $amountPaid;
            $Trans->user_id = $user_id;
            $Trans->mpesa_trans_id = $mpesaTransactionId;
            $Trans->pay_phone_no=$formatedPhone;
            $Trans->save();
            $Trans->status = 1;
            $Trans->save();

            return response()->json([
                'message'=>'transaction successfully saved in the database',
                'status'=>'200'
            ]);

        }
        return response()->json([
            'message'=>'failed please contact the us',
            'status'=>'300'
        ]);
    }
}
