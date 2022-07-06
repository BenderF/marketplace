<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function creditCardPay()
    {
        $client = new Client();

        $response = $client->request('POST', 'https://sandbox.api.pagseguro.com/charges',
            ['body' => '{
              "amount": {
                "value": "$price",
                "currency": "BRL"
              },
              "payment_method": {
                "card": {
                  "holder": {
                    "name": "$cardholder_name"
                  },
                  "id": "$id_card",
                  "number": "$card_num",
                  "network_token": "$network_token",
                  "exp_month": "$exp_month",
                  "exp_year": "$exp_year",
                  "security_code": "$sec_code",
                  "store": true
                },
                "token_data": {
                  "requestor_id": "$req_id",
                  "wallet": "SAMSUNG_PAY",
                  "cryptogram": "$crypt",
                  "ecommerce_domain": "$domain",
                  "assurance_level": "$ass_level"
                },
                "authentication_method": {
                  "type": "THREEDS",
                  "cavv": "$cavv",
                  "eci": "$ecom_resp"
                },
                "type": "CREDIT_CARD",
                "installments": "$parcelas",
                "capture": false,
                "soft_descriptor": "$shop"
              },
              "reference_id": "$id",
              "description": "compra-produto"
            }',
        'headers' => ['Accept' => 'application/json',
            'Authorization' => '$token',
        'Content-type' => 'application/json',],]);

        return $response->getBody();
    }



}
