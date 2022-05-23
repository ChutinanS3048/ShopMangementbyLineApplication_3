<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ประภทสินค้า</title>

<link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/<?php include '../resources/config/theme_name.php';?>/jquery-ui.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="../resources/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

  <style>
  .ui-menu {
    width: 200px;
  }
  </style>

</head>

<body>

<ul id="menu">
  <li>
    <div>Item 1</div>
  </li>
  <li>
    <div>Item 2</div>
  </li>
  <li>
    <div>Item 3</div>
    <ul>
      <li>
        <div>Item 3-1</div>
      </li>
      <li>
        <div>Item 3-2</div>
      </li>
      <li>
        <div>Item 3-3</div>
      </li>
    </ul>
  </li>
  <li>
    <div>Item 4</div>
  </li>
  <li>
    <div>Item 5</div>
  </li>
</ul>

  <script>
$("#menu").menu();

$( ".selector" ).menu({
  menus: "div"
});

</script>



</body>
</html>