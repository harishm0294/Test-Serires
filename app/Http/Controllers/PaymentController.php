<?php

namespace App\Http\Controllers;

use App\Payment;
use App\category;
use App\Aexam;

use PaytmWallet;

use Illuminate\Http\Request;

class PaymentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
    */
    public function order(Request $req, $type, $id)
    {
      if ($type == 'test') {
        $examData = Aexam::where('examcode', $id)->first();
      
        $fee = $examData->fee;
        $examcode = $examData->examcode;
        
      } else {
        $categoryData = category::where('id', $id)->get();
      
        dd($categoryData);
      }

      $payment = PaytmWallet::with('receive');
        
        /*$payment->prepare([
          'order' => $order->id,
          'user' => $user->id,
          'mobile_number' => $user->phonenumber,
          'email' => $user->email,
          'amount' => $order->amount,
          'callback_url' => 'http://example.com/payment/status'
        ]);
      */
        return $payment->receive();
    }

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        
        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        
        if($transaction->isSuccessful()){
          //Transaction Successful
        }else if($transaction->isFailed()){
          //Transaction Failed
        }else if($transaction->isOpen()){
          //Transaction Open/Processing
        }
        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id


    }  
}
