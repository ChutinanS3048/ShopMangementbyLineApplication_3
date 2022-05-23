<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";

$access_token = 'DYi8GuGxE/KznrcW5MP1fRjyek25xLNUaJzqQei+qZJYkDM2PfCqyhCRbPZDRro0YmH9jF6s0NKPLsmiYVh7snOjR42lL1LdIAInCZ0woxYakLq/+TJx7nQyBSKUVWiDOig2tLVYFdHzvdXU0IPr0gdB04t89/1O/w1cDnyilFU=';

$channelSecret = '1327c80c1582542de080a25dd8baaf79';

$pushID = '1655778155';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

?>





