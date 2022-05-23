<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ประภทสินค้า</title>
<link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/<?php include '../resources/config/theme_name.php';?>/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="../resources/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script>
        function redirectPost(url, data) {
            var form = document.createElement('form');
            document.body.appendChild(form);
            form.method = 'post';
            form.action = url;
            for (var name in data) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = data[name];
                form.appendChild(input);
            }
            form.submit();
        }  
</script>
</head>

<body>
<?php include '../resources/components/menu.php'?>
<center>
  <h3>ประเภทสินค้า</h3>
</center>
<div style="height:20px; display:block;"/>
<center>
  <?php
// define variables and set to empty values
$category = $comment;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $category = test_input($_POST["category"]);
  $comment = test_input($_POST["comment"]);
  
  if($category == null || $comment == null){
	  echo '<span style="color:red;">พิมพ์ข้อมูลไม่ครบ</span>';
  }else{
	  $postData = "{ category: '".$_POST["category"]."', comment: '".$_POST["comment"]."' }";
	  echo "<script>";
	  echo "redirectPost('add.php', ".$postData.");";	  
	  echo "</script>";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
    <table border="0" cellpadding="5" cellspacing="5">
      <tr>
        <td><label class="text ui-widget">ประเภทสินค้า</label></td>
        <td><input id="categoryAdd" type="text" name="category" class="ui-widget ui-corner-all"></td>
        <td><label class="text ui-widget">หมายเหตุ</label></td>
        <td><input id="commnetAdd" type="text" name="comment" class="ui-widget ui-corner-all"></td>
        <td><input type="submit" name="submit" value="เพิ่ม" class="ui-button ui-widget ui-corner-all"></td>
      </tr>
    </table>
  </form>
  <br/>
  
  <?php include '../resources/config/database.php';?>
  
  <div style="height:20px; display:block;"/>
  <div id="users-contain" class="ui-widget">
    <table id="users" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
      <thead>
        <tr class="ui-widget-header ">
          <th>รหัสประเภท</th>
          <th>ประเภทสินค้า</th>
          <th>หมายเหตุ</th>
          <th><span class="ui-icon ui-icon-pencil"/></th>
          <th><span class="ui-icon ui-icon-trash"/></th>
        </tr>
      </thead>
      <tbody>
        <?php
$sql = "SELECT category_id, name, comment FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row  
  while($row = $result->fetch_assoc()) {
	  ?>
        <tr>
          <td align="center"><?php echo $row["category_id"]?></td>
          <td><?php echo $row["name"]?></td>
          <td><?php echo $row["comment"]?></td>
          <td><a href="edit.php?id=">แก้ไข</a></td>
          <td><a href="delete.php?id=<?php echo $row["category_id"] ?>">ลบ</a></td>
        </tr>
        <?php
    }
} 
  $conn->close();
  ?>
      </tbody>
    </table>
  </div>
</center>
</body>
</html>

</body>
</html>