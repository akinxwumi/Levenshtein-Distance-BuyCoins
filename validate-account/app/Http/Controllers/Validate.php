<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Validate extends Controller
{
	public function getAccountDetails($args){
	//function to get account details (account_number, bank_name, account_name) from a GraphQL mutation
	return json_decode($args);
	}

    public function callPaystackApi(){

    	/*
    	Receive bank_code and account_number from getAccountDetails()
    	call paystack api to verify account and return response to levenshteinDistance()
    	*/

    	$curl = curl_init();

  		//disables SSL Certificate Verification
  		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

		  /* 
		  Get all bank codes from Paystack API
		  curl_setopt_array($curl, array(
		    CURLOPT_URL => "https://api.paystack.co/bank",
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_MAXREDIRS => 10,
		    CURLOPT_TIMEOUT => 30,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "GET",
		    CURLOPT_HTTPHEADER => array(
		      "Authorization: Bearer sk_test_47850d904d884af72f251c57b204146bf62efc8a",
		      "Cache-Control: no-cache",
		    ),
		  ));
		  
		  $response = curl_exec($curl);
		  $err = curl_error($curl);
		  curl_close($curl);
		  
		  if ($err) {
		    echo "cURL Error #:" . $err;
		  } else {
		    echo $response;
		  }
		  */ 
  
	    curl_setopt_array($curl, array(
    		CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=2009586808&bank_code=057",
    		CURLOPT_RETURNTRANSFER => true,
    		CURLOPT_ENCODING => "",
    		CURLOPT_MAXREDIRS => 10,
    		CURLOPT_TIMEOUT => 30,
    		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    		CURLOPT_CUSTOMREQUEST => "GET",
    		CURLOPT_HTTPHEADER => array(
      		"Authorization: Bearer sk_test_47850d904d884af72f251c57b204146bf62efc8a",
      		"Cache-Control: no-cache",
    		),
  		));
  
	  $response = curl_exec($curl);
  	  $err = curl_error($curl);
  
	  curl_close($curl);
  
	  if ($err) {
	    echo "cURL Error #:" . $err;
	  } else {
	    echo $response;
	  }
	}

	public function validateAccountName(){
		/*
		check if the account_name from getAccountDetails() matches the one from Paystack's API. If it matches, pass a response to addAccountDetails() else, calcLevenshteinDistance()
		*/
	}


	public function calcLevenshteinDistance(){
		/*
		calculate the LD between account_name from getAccountDetails and callPaystackApi. If it is <=2 pass the response to addAccountDetails() else, 
		*/
	}

	public function addAccountDetails(){
		/*
		if LD is <=2, pass account details and set is_verified attribute to true for the GraphQL mutation else, set is_verified to false
		Attributes in the mutation will be is_verified, user_account_name, user_account_number, paystack_account_number and user_bank_code
		Return result to the frontend via a GraphQL mutation
		*/
	}

	public function returnAccountName(){
	/*
	Call the GraphQL mutation to query for user_account_name paystack_account_name using the user_bank_code and user_account_number parameter. If user_account_name is available, return it else, it return paystack_account_name.	
	Please note that the query must check for user_account_name not this function
	*/
	}


	public function basicUnitTests(){
	//basic unit testing		
	}

}
