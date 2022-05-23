<?php // callback.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

include '../resources/config/line.php';

$domain = 'http://185.78.164.69/shop';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$userId = $event['source']['userId'];

			// Get Input Text
			$inputText = $event['message']['text'];


			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back


			/* แบบใช้ Array
			$messages = [
				'type' => 'text',
				'text' => 'คลิ๊ก Link เพื่อลงทะเบียน' . "\r\n" . $domain . '/mobile/register/?token=' . $userId
			];

			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];

			$post = json_encode($data);

			*/

			$richTopic;
			$post;

			if ($inputText == 'ลงทะเบียนสมาชิกใหม่') {
				$richTopic = 'สมัครสมาชิกใหม่';
				$post = '{"replyToken":"' . $replyToken . '",
					"messages": [
						{
						 "type": "flex",
						 "altText": "สมัครสมาชิก",
						 "contents": {
						  "type": "bubble",
						  "body": {
						   "type": "box",
						   "layout": "vertical",
						   "contents": [
							{
							 "type": "button",
							 "style": "primary",
							 "height": "sm",
							 "action": {
							  "type": "uri",
							  "label": "ลงทะเบียนสมาชิก",
							  "uri": "' . $domain . '/mobile/register/?user=' . $userId . '"
							 }
							}
						   ]
						  }
						 }
						}
					   ]
					}';
			} else if ($inputText == 'เบิกสินค้า') {
				$richTopic = 'เบิกสินค้า';
				$post = '{"replyToken":"' . $replyToken . '",
					"messages": [
						{
						 "type": "flex",
						 "altText": "เบิกสินค้า",
						 "contents": {
						  "type": "bubble",
						  "body": {
						   "type": "box",
						   "layout": "vertical",
						   "contents": [
							{
							 "type": "button",
							 "style": "primary",
							 "height": "sm",
							 "action": {
							  "type": "uri",
							  "label": "เบิกสินค้า",
							  "uri": "' . $domain . '/mobile/request/?user=' . $userId . '"
							 }
							}
						   ]
						  }
						 }
						}
					   ]
					}';
			} else if ($inputText == 'ดูใบเบิกสินค้า') {
				$richTopic = 'ดูใบเบิกสินค้า';
				$post = '{"replyToken":"' . $replyToken . '",
					"messages": [
						{
						 "type": "flex",
						 "altText": "ดูใบเบิกสินค้า",
						 "contents": {
						  "type": "bubble",
						  "body": {
						   "type": "box",
						   "layout": "vertical",
						   "contents": [
							{
							 "type": "button",
							 "style": "primary",
							 "height": "sm",
							 "action": {
							  "type": "uri",
							  "label": "ดูใบเบิกสินค้า",
							  "uri": "' . $domain . '/mobile/invoice/?user=' . $userId . '"
							 }
							}
						   ]
						  }
						 }
						}
					   ]
					}';
			}

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';

			$headers = array('Content-Type: application/json; charset=UTF-8', 'cache-control: no-cache', 'Authorization: Bearer ' . $access_token);

			try {
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$result = curl_exec($ch);
				curl_close($ch);
				echo $result . "\r\n";

				saveLog($richTopic, $userId, $inputText, $replyToken, $post);
			} catch (Exception $ex) {

				file_put_contents('error.txt', $ex . PHP_EOL, FILE_APPEND);

				echo $ex;
			}
		}
	}
}

function saveLog($topic, $user_id, $user_message, $reply_token, $json_reply)
{
	include '../resources/config/database.php';

	$sql = "INSERT INTO reply_logs (topic, user_masage, user_id, token_reply, json_reply) 
	VALUES ('" . $topic . "', '" . $user_message . "', '" . $user_id . "', '" . $reply_token . "', '" . $json_reply . "');";

	if ($conn->query($sql) === TRUE) {
		$conn->close();
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	$conn->close();
}
echo "OK";
