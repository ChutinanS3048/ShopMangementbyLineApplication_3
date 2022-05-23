<?php
session_start();

if (!isset($_SESSION['first_name']) && empty($_SESSION['first_name'])) {
    header("refresh: 2; url=/shop/");
    exit(0);
}
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>หน้าหลัก</title>
    <link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/<?php include '../resources/config/theme_name.php'; ?>/jquery-ui.css">
    <script src="../resources/js/jquery-1.12.4.js"></script>
    <script src="../resources/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
</head>

<body>
    

    <?php
    include '../resources/components/menu.php';
    ?>
    <center>
        <h3>หน้าหลัก</h3>
    </center>

    <div style="height:20px; display:block;" />
    <center>
        ยินดีต้อนรับคุณ
        <p>
            <label style="font-weight: bold;"><?php echo $_SESSION["first_name"]; ?>&nbsp;<?php echo $_SESSION["last_name"]; ?></label>
        </p>
        เข้าสู่ระบบ
        <br />
        กรุณาเลือกทำรายการ...

    </center>
</body>

</html>