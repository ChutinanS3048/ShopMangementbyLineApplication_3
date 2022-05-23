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
    <title>สินค้า</title>
    <link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/<?php include '../resources/config/theme_name.php'; ?>/jquery-ui.css">
    <script src="../resources/js/jquery-1.12.4.js"></script>
    <script src="../resources/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

</head>

<body>

    <?php
    include '../resources/components/menu.php';
    include '../resources/config/database.php';
    ?>

    <center>
        <h3>ผู้ใช้ระบบ (Line)</h3>
    </center>

    <div style="height:20px; display:block;" />
    <center>

        <br />
        <div style="height:20px; display:block;" />
        <table id="categoryTb" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
            <thead class="ui-widget-header">
                <tr>
                    <th>
                        ชื่อ
                    </th>
                    <th>
                        นามสกุล
                    </th>
                    <th>
                        ชื่อเล่น
                    </th>
                    <th>
                        ที่อยู่
                    </th>
                    <th>
                        ตำบล/แขวง
                    </th>
                    <th>
                        อำเภอ
                    </th>
                    <th>
                        จังหวัด
                    </th>
                    <th>
                        รหัสไปรษณีย์
                    </th>
                    <th>
                        โทรศัพท์
                    </th>
                    <th>
                        อีเมล์
                    </th>
                    <th>
                        Line ID
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM partner;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr id="row<?php echo $row["partner_id"]; ?>">
                            <td align="center">
                                <?php echo $row["first_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["last_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["nick_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["address"]; ?>
                            </td>
                            <td>
                                <?php echo $row["sub_district"]; ?>
                            </td>
                            <td>
                                <?php echo $row["district"]; ?>
                            </td>
                            <td>
                                <?php echo $row["province"]; ?>
                            </td>
                            <td>
                                <?php echo $row["zipcode"]; ?>
                            </td>
                            <td>
                                <?php echo $row["mobile"]; ?>
                            </td>
                            <td>
                                <?php echo $row["email"]; ?>
                            </td>
                            <td>
                                <?php echo $row["line_id"]; ?>
                            </td>                            
                        </tr>
                <?php
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>

    </center>
</body>

</html>