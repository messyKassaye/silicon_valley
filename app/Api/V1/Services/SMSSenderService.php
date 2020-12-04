<?php


namespace App\Api\V1\Services;


use GuzzleHttp\Client;

class SMSSenderService
{

    public function send($receiver,$message){
        $client = new Client();
      $res =  $client->request(
            'POST',
            'https://us-central1-guloadssms.cloudfunctions.net/api/message',
          [
              'form_params'=>[
                  'receiver'=>$receiver,
                  'sender'=>env('SENDER_PHONE'),
                  'message'=>$message
              ]
          ]
        );

      if ($res->getStatusCode()===200){
          return true;//response()->json(['status'=>true,'message'=>'Message sent successfully']);
      }
    }
}