<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ประภทสินค้า</title>
<link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/excite-bike/jquery-ui.css">
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
		
	function addTable(id, category, comment){
			alert("fuck");

		$( "#categoryTb tbody" ).append( "<tr>" +
          	"<td>" + id.val() + "</td>" +
          	"<td>" + category.val() + "</td>" +
          	"<td>" + comment.val() + "</td>" +
		  	"<td>เพิ่ม/ลบ</td>" +
        	"</tr>" );

	}
		  
</script>
</head>

<body>

<div class="text ui-widget-header ui-corner-all" >
<center>
<table border="0" cellpadding="5" cellspacing="5">
<tr>
<td>
 <a href="../category">ประเภทสินค้า</a>
</td>
<td>
 <a href="../product">สินค้า</a>
</td>
<td>
 <a href="../partner">รายชื่อสมาชิก</a>
</td>
<td>
 <a href="../product">การเบิกสินค้า</a>
</td>
<td>
 <a href="#ประเภทสินค้า">ออกจากระบบ</a>
</td>
</tr>
</table>
</center>
</div>
<center>
  <h3>ประเภทสินค้า</h3>
</center>

<div style="height:20px; display:block;"/>

<center>


<script>

</script>

  <form action="" method="post">
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
    <div style="height:20px; display:block;"/>
    <table id="categoryTb" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
      <thead class="ui-widget-header">
        <tr>
          <th>รหัสประเภท</th>
          <th>ประเภทสินค้า</th>
          <th>หมายเหตุ</th>
          <th><span class="ui-icon ui-icon-pencil"></span></th>
          <th><span class="ui-icon ui-icon-trash"></span></th>
        </tr>
      </thead>
      
      <tbody>

        <tr>
          <td align="center">1</td>
          <td>ความสวยความงาม</td>
          <td>ใช้ได้ทุกเพศ ทุกวัย</td>
          <td><a href="edit.php?id=">แก้ไข</a></td>
          <td><a href="delete.php?id=1">ลบ</a></td>
        </tr>


        <tr>
          <td align="center">2</td>
          <td>อาหารเสริมควบคุม</td>
          <td>ใช้ได้เป็นบางคน</td>
          <td><a href="edit.php?id=">แก้ไข</a></td>
          <td><a href="delete.php?id=2">ลบ</a></td>
        </tr>


        <tr>
          <td align="center">5</td>
          <td>dddf</td>
          <td>fdfdf</td>
          <td><a href="edit.php?id=">แก้ไข</a></td>
          <td><a href="delete.php?id=5">ลบ</a></td>
        </tr>


        <tr>
          <td align="center">6</td>
          <td>dfdfdf</td>
          <td>dfdf</td>
          <td><a href="edit.php?id=">แก้ไข</a></td>
          <td><a href="delete.php?id=6">ลบ</a></td>
        </tr>


        <tr>
          <td align="center">7</td>
          <td>xxx</td>
          <td>xxx</td>
          <td><a href="edit.php?id=">แก้ไข</a></td>
          <td><a href="delete.php?id=7">ลบ</a></td>
        </tr>

      </tbody>
    </table>
</center>
</body>
</html>

