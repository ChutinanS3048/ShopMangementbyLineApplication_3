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
    <script>
        function sendLine(lineId, fName, lName, invoiceId) {

            $.ajax({
                type: "POST",
                url: "send_line.php",
                data: {
                    lineIdForm: lineId,
                    firstNameForm: fName,
                    lastNameForm: lName,
                    invoiceForm: invoiceId
                }
            }).done(function(msg) {
                //alert( "Data Saved: " + msg );
            });
        }
    </script>
</head>

<body>

    <?php
    include '../resources/components/menu.php';
    include '../resources/config/database.php';
    ?>

    <center>
        <h3>การเบิกสินค้า</h3>
    </center>

    <div style="height:20px; display:block;" />
    <center>

        <br />
        <div style="height:20px; display:block;" />
        <table id="categoryTb" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
            <thead class="ui-widget-header">
                <tr>
                    <th align="center">
                        เลขที่ใบสั่งซื้อ
                    </th>
                    <th align="center">
                        วันที่เบิก
                    </th>
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
                        อีเมล์
                    </th>
                    <th>
                        โทรศัพท์
                    </th>
                    <th align="center">
                        แจ้งเตือนไปยังไลน์
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT invoice.invoice_id, invoice.request_date, partner.first_name, 
                partner.last_name, partner.nick_name, partner.email, partner.mobile, partner.line_id  
                FROM invoice 
                INNER JOIN partner ON (invoice.partner_id = partner.partner_id)
                ORDER BY invoice.invoice_id DESC;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr id="row<?php echo $row["invoice_id"]; ?>">
                            <td align="center">
                                ABC<?php echo $row["invoice_id"]; ?>
                            </td>
                            <td align="center">
                                ABC<?php echo dateThai($row["request_date"]); ?>
                            </td>
                            <td>
                                <?php echo $row["first_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["last_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["nick_name"]; ?>
                            </td>
                            <td>
                                <?php echo $row["email"]; ?>
                            </td>
                            <td>
                                <?php echo $row["mobile"]; ?>
                            </td>
                            <td align="center">
                                <button class="btn btn-outline-info" onclick="sendLine('<?php echo $row["line_id"] ?>', '<?php echo $row["first_name"] ?>', '<?php echo $row["last_name"] ?>', '<?php echo $row["invoice_id"] ?>');">
                                    <span class="ui-icon ui-icon-comment">
                                        ส่งไลน์
                                    </span>
                                </button>
                            </td>
                        </tr>
                <?php
                    }
                }
                $conn->close();

                function dateThai($strDate)
                {
                    $strYear = date("Y", strtotime($strDate)) + 543;
                    $strMonth = date("n", strtotime($strDate));
                    $strDay = date("j", strtotime($strDate));
                    $strHour = date("H", strtotime($strDate));
                    $strMinute = date("i", strtotime($strDate));
                    $strSeconds = date("s", strtotime($strDate));
                    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
                    $strMonthThai = $strMonthCut[$strMonth];
                    return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
                }


                ?>
            </tbody>
        </table>

    </center>
</body>

</html>