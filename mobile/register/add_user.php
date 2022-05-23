<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$firstName = $_POST["firstNameForm"];
	$lastName = $_POST["lastNameForm"];
	$nickName = $_POST["nickNameForm"];
	$address = $_POST["addressForm"];
	$subDistrict = $_POST["subDistrictForm"];
	$district = $_POST["districtForm"];
	$province = $_POST["provinceForm"];
	$zipcode = $_POST["zipcodeForm"];
	$mobile = $_POST["mobileForm"];
	$email = $_POST["emailForm"];
	$lineId = $_POST["lineIdForm"];

	include '../../resources/config/database.php';

	$sql = "INSERT INTO partner (first_name, last_name, nick_name, `address`, sub_district, district, province, zipcode, mobile, email, line_id, active)
         VALUES ('" . $firstName . "', '" . $lastName . "', '" . $nickName . "', '" . $address . "', '" . $subDistrict . "', '" . $district . "',
          '" . $province . "', '" . $zipcode . "', '" . $mobile . "', '" . $email . "', '" . $lineId . "', true);";

	if ($conn->query($sql) === TRUE) {

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
					  "text":"ระบบได้ทำการลงทะเบียนสมาชิกให้คุณเรียบร้อยแล้ว"
				 },
				 {
					"type": "sticker",
					"packageId": "11538",
					"stickerId": "51626500"
				  }
			]
	   }';

		include '../../resources/config/line.php';
		require_once('../../line-bot/push.php');
		$sendLine = new push();
		$sendLine->send($json, $access_token);

		// แทรก Logs การส่งข้อความไปที่ฐานข้อมูล
		$sql = "INSERT INTO push_logs (user_id, json_push) VALUES ('" . $lineId . "', '" . $json . "');";

		if ($conn->query($sql) === TRUE) {
			$conn->close();
		}
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
} 
