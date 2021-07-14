<?php

namespace App\Http\Controllers;

require_once("paytm/config_paytm.php");
require_once("paytm/encdec_paytm.php");

use App\Payment;
use App\category;
use App\Aexam;
use Auth;

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
        
        $paytmData = Payment::create([
          'payment' => $fee,
          'examcode' => $examcode,
          'user_id' => Auth::id(),
          'checksum' => "test",
          'status' => 'pending',
          'payment_mode' => 'paytm'
        ]);
      } else {
        $categoryData = category::where('id', $id)->first();
        $fee = $categoryData->fee;
        $examcode = $categoryData->examcode;
        
        $paytmData = Payment::create([
          'payment' => $fee,
          'category' => $examcode,
          'user_id' => Auth::id(),
          'checksum' => "test1",
          'status' => 'pending',
          'payment_mode' => 'paytm'
        ]);
      }

        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $paytmData->id;     
        $paramList["CUST_ID"] = $paytmData->user_id;
        $paramList["INDUSTRY_TYPE_ID"] = 'RETIAL';
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] = $fee;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
  
        $paramList["CALLBACK_URL"] = url('/payment/status');
        $paramList["MSISDN"] = '77777777';
        $paramList["EMAIL"] ='foo@gmail.com';
        $paramList["VERIFIED_BY"] = "EMAIL";
        $paramList["IS_USER_VERIFIED"] = "YES";
        $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
      ?>

      <form id="myForm" action="<?php echo PAYTM_TXN_URL ?>" method="post">
        <?php
          foreach ($paramList as $a => $b) {
            echo '<input type="hidden" name="'.htmlentities($a).'" value="'.htmlentities($b).'">';
          }
        ?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
      </form>
      <script type="text/javascript">
          document.getElementById('myForm').submit();
      </script>

      <?php
    }

    /**
     * Obtain the paytm payment Response information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
      $paytmChecksum = "";
      $paramList = array();
      $isValidChecksum = "FALSE";

      $paramList = $_POST;
      
      $data = [
        'transaction_id' => $paramList['TXNID'],
        'payment' => $paramList['TXNAMOUNT'],
        'payment_mode' => $paramList['PAYMENTMODE'],
        'status' => $paramList['STATUS'],
        'checksum' => $paramList['CHECKSUMHASH'],
        'bank_transaction' => $paramList['BANKTXNID'],
      ];

      Payment::where('id', $paramList['ORDERID'])
      ->update($data);
      
      return redirect()->route('MyExams')->with('success', 'your message,here'); 
    }  
}
?>