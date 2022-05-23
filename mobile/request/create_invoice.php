<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $productIdArr = $_POST['proIdForm'];
  $quantityArr = $_POST['quantityForm'];

  include '../../resources/config/database.php';

  // ค้นหา Partner ID ผู้ใช้จาก Line ID
  $partnerId;

  $sql = "SELECT partner_id FROM partner WHERE line_id='" . $_POST['lineIdForm'] . "';";
  $result = $conn->query($sql);
  $row = $result->fetch_row();
  $partnerId = $row[0];

  // สร้าง invoice ID เลขที่ใหม่
  $invoiceId;

  $sql = "SELECT invoice_id FROM invoice ORDER BY invoice_id DESC LIMIT 1;";
  $result = $conn->query($sql);

  if ($result) {
    $row = $result->fetch_row();
    $invoiceId = $row[0] + 1;
  } else {
    $invoiceId = 1;
  }

  // สร้าง Invoice ใบใหม่
  $sql = "INSERT INTO invoice (invoice_id, partner_id, request_date) VALUES (" . $invoiceId . ", " . $partnerId . ", NOW());";
  if ($conn->query($sql) === TRUE) {
  }

  // แทรกรายการสั่งซื้อเข้าไปใน Invoice และตัด Stock เลย
  foreach ($productIdArr as $key => $proId) {

    if ($conn->query("INSERT INTO invoice_detail (invoice_id, product_id, quantity) VALUES (" . $invoiceId . ", " . $proId . ", " . $quantityArr[$key] . ");") === TRUE) {
    }
    // ตัด Stock
    if ($conn->query("UPDATE product SET inventory = inventory - " . $quantityArr[$key] . " WHERE product_id = " . $proId . ";") === TRUE) {
    }
  }

  // ค้นหาสินค้าใกล้หมด
  include '../../resources/config/left_hand_stock.php';

  $leftHandName = array();
  $leftHandInventory = array();

  $sql = "SELECT `name`, inventory FROM product WHERE inventory <= " . $left_hand_stock . " AND inventory !=0;";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
      $leftHandName[$i] = $row['name'];
      $leftHandInventory[$i] = $row['inventory'];
      $i++;
    }
  }

  // แจ้งเตือนสินค้าใกล้หมดไปยัง Line
  if (count($leftHandName) != 0) {
    include '../../resources/config/line.php';
    require_once('../../line-bot/push.php');
    $sendLine = new push();

    $lineUserId = array();
    $firstName = array();
    $lastNameId = array();

    $sql = "SELECT first_name, last_name, line_id FROM partner;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $i = 0;
      while ($row = $result->fetch_assoc()) {
        $lineUserId[$i] = $row['line_id'];
        $firstName[$i] = $row['first_name'];
        $lastName[$i] = $row['last_name'];
        $i++;
      }
    }


    // ส่งข้อความไลน์
    // ข้อความ "ชื่อ นามสกุล" ผู้ใช้งาน
    foreach ($lineUserId as $key1 => $userId) {
      $json = '{
        "to": "' . $userId . '",
        "messages":[
           {
              "type":"text",
              "text":"เรียน คุณ' . $firstName[$key1] . ' ' . $lastName[$key1] . '"
           }
        ]
       }';

      $sendLine->send($json, $access_token);

      // รายการสินค้าใกล้หมด
      foreach ($leftHandName  as $key2 => $name) {
        $json = '{
          "to": "' . $userId . '",
          "messages":[
             {
                "type":"text",
                "text":"' . $name . ' เหลือแค่ ' . $leftHandInventory[$key2] . ' ชิ้น"
             }
          ]
         }';
        $sendLine->send($json, $access_token);

        // แทรก Logs การส่งข้อความไปที่ฐานข้อมูล
        $sql = "INSERT INTO push_logs (user_id, json_push) VALUES ('" . $userId . "', '" . $json . "');";
        if ($conn->query($sql) === TRUE) {
        }
      }

      // ส่งสติ๊กเกอร์อีกที
      $json = '{
        "to": "' . $_POST['lineIdForm'] . '",
        "messages":[
          {
            "type": "sticker",
            "packageId": "2",
            "stickerId": "34"
          }
       ]
      }';
    }
    $sendLine->send($json, $access_token);
    $sql = "INSERT INTO push_logs (user_id, json_push) VALUES ('" . $userId . "', '" . $json . "');";
    if ($conn->query($sql) === TRUE) {
    }
  }

  $conn->close();
  //file_put_contents('json.txt', $sql .  PHP_EOL, FILE_APPEND);

}
