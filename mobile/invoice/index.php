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
            <h1>ใบเบิกสินค้า</h1>
        </div>

        <div role="main" class="ui-content">
            <p>
            <table data-role="table" class="ui-body-d ui-shadow table-stripe ui-responsive">
                <thead>
                    <tr>
                        <th>เลขที่</th>
                        <th>วันที่เบิก</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include '../../resources/config/database.php';

                    $sql = "SELECT invoice.invoice_id, invoice.request_date FROM shop.invoice 
                    INNER JOIN partner ON(invoice.partner_id = partner.partner_id)
                    WHERE partner.line_id = '" . $_GET["user"] . "'
                    ORDER BY invoice.request_date DESC;";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td>
                                    <label>ABC<?php echo $row["invoice_id"]; ?></label>
                                </td>
                                <td>
                                    <label><?php echo dateThai($row["request_date"]); ?></label>
                                </td>
                                <td>
                                    <a href="view.php?user=<?php echo $_GET["user"]; ?>&id=<?php echo $row["invoice_id"]; ?>&date=<?php echo $row["request_date"]; ?>" class="ui-btn ui-btn-inline ui-icon-eye ui-btn-icon-right">ดูรายละเอียด</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            </p>

            <p style="text-align: center;">
                <a href="https://line.me/R/nv/chat" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-icon-check ui-btn-icon-right" data-theme="b">ปิด</a>
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
