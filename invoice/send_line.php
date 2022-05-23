<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {	
        $lineId = $_POST["lineIdForm"]; 
        $firstName = $_POST["firstNameForm"]; 
        $lastName = $_POST["lastNameForm"]; 
        $invoiceId = $_POST["invoiceForm"]; 

        // ส่งข้อความกลับไปบอก User ว่าลงทะเบียนเรียบร้อยแล้ว
		$json = '{
			"to": "' . $lineId . '",
			"messages":[
				 {
					  "type":"text",
					  "text":"เรียน คุณ' . $firstName . ' ' . $lastName . '"
				 },
				 {
					  "type":"text",
					  "text":"เราได้รับใบเบิกสินค้า เลขที่ ABC'.$invoiceId.' ของคุณเรียบร้อยแล้ว\r\nเราได้ทำการ....แล้วนะคะ"
				 },
				 {
					"type": "sticker",
					"packageId": "11539",
					"stickerId": "52114140"
				  }
			]
	   }';

		include '../resources/config/line.php';
		require_once('../line-bot/push.php');
		$sendLine = new push();
		$sendLine->send($json, $access_token);

		include '../resources/config/database.php';
	  
		$sql = "INSERT INTO push_logs (user_id, json_push) VALUES ('" . $lineId . "', '" . $json . "');";

		if ($conn->query($sql) === TRUE) {
			$conn->close();
		}

	$conn->close();
	  
	}else{	
	   	header( "refresh: 2; url=/shop/product" );
		exit(0);
	}
?>