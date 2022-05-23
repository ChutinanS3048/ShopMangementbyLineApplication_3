    
<html>
<head>
<!-- Vendor CSS Files -->
<link href="../assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style > 
        body{
            background-image: url('../assets/img/1.png');
        }
       
    </style>
</head>
<body >

<div >
<?php

echo '<div class="text ui-widget-header ui-corner-all bg-primary text-white " >
<center style="background-color:#37517e">
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
<a href="../invoice">การเบิกสินค้า</a>
</td>';

if($_SESSION["level"] == 1){
    echo '<td>
    <a href="../summary">สรุปยอดขาย</a>
</td>';
}

echo'<td>
<a href="../logout">ออกจากระบบ</a>
</td>
</tr>
</table>
</center>
</div>';
?>
<br>
<br>
<br>
</div>
    

</body>
</html>




