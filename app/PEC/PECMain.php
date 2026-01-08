<?php

namespace App\PEC;

use App\Models\transactionstemp;
use App\myappenv;
use Illuminate\Http\Request;

require_once('nusoap.php');

class PECMain
{
	public function request($Amount)
	{
		$LoginAccount 	= '3fflbG3Wua6AQ2LrTXk3';
		$OrderId 		= time();
		$CallBackUrl = url('/') . '/api/pec';
		$client = new nusoap_client('https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl', 'wsdl');
		$client->soap_defencoding = 'UTF-8';

		$result = $client->call('SalePaymentRequest', array(
			"requestData" =>
			array(
				'LoginAccount' 		=> $LoginAccount,
				'Amount' 			=> $Amount,
				'OrderId' 			=> $OrderId,
				'CallBackUrl' 		=> $CallBackUrl,
				'AdditionalData' 	=> ''
			),
		));


		if (isset($result['SalePaymentRequestResult']) && $result['SalePaymentRequestResult'] != "") {
			$result = $result['SalePaymentRequestResult'];

			if (isset($result['Status']) && $result['Status'] == 0 && isset($result['Token']) && $result['Token'] != "") {
				$token = $result['Token'];
				$DBData = [
					'strid' => $token,
					'Amount' => $Amount,
					'gateway' => 'pec'
				];
				transactionstemp::create($DBData);
				echo "https://pec.shaparak.ir/NewIPG/?Token={$token}";
				return redirect()->to("https://pec.shaparak.ir/NewIPG/?Token={$token}");
				
			} else {
				echo "Error : {$result['Status']}";
			}
		} else {
			echo "No response from the bank";
		}
	}

	public function revicer(Request $request)
	{
		
		$LoginAccount 	= '3fflbG3Wua6AQ2LrTXk3';

		if ($request->has('status')  && $request->status == 0 && $request->has('Token') && $request->Token != "") {
			$client = new nusoap_client('https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?wsdl', 'wsdl');
			$client->soap_defencoding = 'UTF-8';

			$result = $client->call('ConfirmPayment', array(
				"requestData" =>
				array(
					'LoginAccount' 		=> $LoginAccount,
					'Token' 			=> $request->Token
				),
			));
		//	dd($request->input(),$result );
			if (isset($result['ConfirmPaymentResult']) && $result['ConfirmPaymentResult'] != "") {
				$result = $result['ConfirmPaymentResult'];
				if (isset($result['Status']) && $result['Status'] == 0 && isset($result['RRN']) && $result['RRN'] > 0) {
					$bankReference 		= (isset($result['RRN']) && $result['RRN'] > 0) 							? $result['RRN'] 				: "";
					$cardNumberMasked 	= (isset($result['CardNumberMasked']) && $result['CardNumberMasked'] != "") ? $result['CardNumberMasked'] 	: "";
					$requestId =  $result['Token'];
					$result = $result['Status'];
					$systemTraceAuditNumber = $bankReference;
					transactionstemp::where('strid', $requestId)->where('gateway', 'pec')->update(['refnumber' => $systemTraceAuditNumber]);
					return redirect()->route('ConfirmPayment', ['pay' => 'PEC', 'ref' => $systemTraceAuditNumber]);
				} else {
					echo "Error : {$result['Status']}";
					return redirect()->route('checkout', ['pay' => 'PEC', 'ref' => 'Faild']);
				}
			} else {
				echo "No response from the bank";
				return redirect()->route('checkout', ['pay' => 'PEC', 'ref' => 'Faild']);
			}
		} else {
			echo "Transaction canceled by user";
			return redirect()->route('checkout', ['pay' => 'PEC', 'ref' => 'Faild']);
		}
	}
}
