<?php

class push
{
     public function send($json, $access_token)
     {
          $url = 'https://api.line.me/v2/bot/message/push';
          $headers = array('Content-Type: application/json; charset=UTF-8', 'cache-control: no-cache', 'Authorization: Bearer ' . $access_token);

          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

          $result = curl_exec($ch);
          curl_close($ch);
          echo $result . "\r\n";

     }
}
