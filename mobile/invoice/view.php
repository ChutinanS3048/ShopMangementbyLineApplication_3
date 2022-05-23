<!DOCTYPE html>
<html>

<head>
    <title>ใบเบิกสินค้า</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../resource/jquerymobile/jquery.mobile-1.4.5.min.css" />
    <script src="../resource/jquerymobile/jquery-1.12.4.js"></script>
    <script src="../resource/jquerymobile/jquery.mobile-1.4.5.min.js"></script>

</head>

<body>

    <div data-role="page">

        <div data-role="header" data-position="fixed" class="ui-bar">
            <h1>รายละเอียดใบเบิกสินค้า</h1>
        </div>

        <div role="main" class="ui-content">
            <div style="text-align: center; display: block; width: 100%;">
                <h1>เลขที่ ABC<?php echo $_GET["id"]; ?></h1>
                <?php echo dateThai($_GET["date"]); ?>
            </div>
            <p>
            <table data-role="table" class="ui-body-d ui-shadow table-stripe ui-responsive">
                <thead>
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>จำนวน</th>
                        <th>ราคา</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include '../../resources/config/database.php';

                    $total = 0;

                    $sql = "SELECT product.`name`, product.price, invoice_detail.quantity 
                    FROM shop.invoice_detail 
                    INNER JOIN product ON (invoice_detail.product_id = product.product_id) 
                    WHERE invoice_detail.invoice_id = " . $_GET["id"] . ";";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td>
                                    <label><?php echo $row["name"]; ?></label>
                                </td>
                                <td>
                                    <label><?php echo $row["quantity"]; ?></label>
                                </td>
                                <td>
                                    <label><?php echo $row["price"]; ?></label>
                                </td>
                            </tr>
                    <?php

                            $total = $total + ($row["quantity"] * $row["price"]);

                        }
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            </p>
            <div style="text-align: center; display: block; width: 100%;">
                <h2>รวมทั้งสิ้น <?php echo $total; ?> บาท</h2>
            </div>

            <p>
                <a href="index.php?user=<?php echo $_GET["user"]; ?>" class="ui-btn ui-icon-back ui-btn-icon-right">กลับไป</a>
            </p>
        </div>

        <div data-role="footer" data-position="fixed" class="ui-bar" style="bottom:0; position:absolute !important; top: auto !important; width:100%;">
            <h4>Shop Management</h4>
        </div>
    </div>

    <?php
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

</body>

</html>
