<?php
session_start();

if (!isset($_SESSION['first_name']) && empty($_SESSION['first_name'])) {
    header("refresh: 2; url=/shop/");
    exit(0);
}else{
    // ถ้าไม่ใช่ Level 1
    if($_SESSION['level'] != "1"){
        header("refresh: 2; url=/shop/welcome");
        exit(0);
    }
}
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>สรุปยอดขาย</title>
    <link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/<?php include '../resources/config/theme_name.php'; ?>/jquery-ui.css">
    <script src="../resources/js/jquery-1.12.4.js"></script>
    <script src="../resources/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script src="../resources/js/chart.js"></script>
    <script>
        $(function() {
            $("#startDate").datepicker();
            $("#startDate").datepicker("setDate", "today");
            $("#toDate").datepicker();
            $("#toDate").datepicker("setDate", "today");
        });

        function query() {
            type: "GET",
            $.ajax({
                url: 'result.php?start=' + $("#startDate").val() + '&end=' + $("#toDate").val(),
                success: function(response) {
                    //alert(response);
                    $(location).attr('href', 'result.php?start=' + $("#startDate").val() + '&end=' + $("#toDate").val());
                }
            });
        }
    </script>
</head>

<body>

    <?php
    include '../resources/components/menu.php';
    ?>


    <center>
        <h3>สรุปยอดขาย</h3>
    </center>

    <div style="height:20px; display:block;" />
    <center>

        <table border="0" cellpadding="10" cellspace="10">
            <tr>
                <td>เริ่มวันที่</td>
                <td><input type="text" id="startDate" style="text-align: center;"></td>
                <td>ถึงวันที่</td>
                <td><input type="text" id="toDate" style="text-align: center;"></td>
                <td>
                    <button onclick="query();" class="ui-button ui-widget ui-corner-all">
                        ประมวลผล
                        <span class="ui-icon 	ui-icon-calculator">
                        </span>
                    </button>
                </td>
            </tr>
        </table>

        <?php include '../resources/config/database.php'; ?>
        <div style="height:20px; display:block;" />
        <table id="categoryTb" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
            <thead class="ui-widget-header">
                <tr>
                    <th>
                        <label class="text ui-widget">สินค้า</label>
                    </th>
                    <th align="center">
                        <label class="text ui-widget">จำนวนที่ขาย</label>
                        </t่h>
                    <th>
                        <label class="text ui-widget">ต้นทุน</label>
                    </th>
                    <th align="center">
                        <label class="text ui-widget">ยอดขาย</label>
                    </th>
                    <th align="center">
                        <label class="text ui-widget">กำไร</label>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php

                function dateDb($strDate)
                {
                    $strYear = date("Y", strtotime($strDate));
                    $strMonth = date("n", strtotime($strDate));
                    $strDay = date("j", strtotime($strDate));
                    $strHour = date("H", strtotime($strDate));
                    $strMinute = date("i", strtotime($strDate));
                    $strSeconds = date("s", strtotime($strDate));
                    return "$strYear-$strMonth-$strDay $strHour:$strMinute:$strSeconds";
                }

                $profitArr = array();
                $proNameArr = array();

                $qTotal = 0;
                $cTotal = 0;
                $pTotal = 0;
                $pfTotal = 0;
                $i = 0;

                $sql = "SELECT product.`name`, SUM(product.cost) AS cost, SUM(product.price) AS price, 
                SUM(invoice_detail.quantity) AS quantity, SUM(product.price - product.cost) AS profit
                FROM shop.product
                INNER JOIN invoice_detail ON (product.product_id = invoice_detail.product_id)
                INNER JOIN invoice ON (invoice_detail.invoice_id = invoice.invoice_id)
                WHERE invoice.request_date BETWEEN '" .  dateDb($_GET['start']) . "' AND '" . dateDb($_GET['end']) . " 00:00:00'
                GROUP BY product.name
                ORDER BY profit DESC;";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {

                        $profitArr[$i] = $row["profit"];
                        $proNameArr[$i] =  $row["name"];
                ?>
                        <tr>
                            <td>
                                <label><?php echo $row["name"]; ?></label>
                            </td>
                            <td align="center">
                                <label><?php echo $row["quantity"]; ?></label>
                            </td>
                            <td align="center">
                                <label><?php echo $row["cost"]; ?></label>
                            </td>
                            <td align="center">
                                <label><?php echo $row["price"]; ?></label>
                            </td>
                            <td align="center">
                                <label><?php echo $row["profit"]; ?> </label>
                            </td>
                        </tr>
                <?php

                        $i++;

                        $qTotal = $qTotal + $row["quantity"];
                        $cTotal = $cTotal + $row["cost"];
                        $pTotal = $pTotal + $row["price"];
                        $pfTotal = $pfTotal + $row["profit"];
                    }
                }
                $conn->close();
                ?>
            </tbody>
            <tfoot>
                <td align="right">รวม</td>
                <td align="center"><?php echo number_format($qTotal); ?></td>
                <td align="center"><?php echo number_format($cTotal); ?></td>
                <td align="center"><?php echo number_format($pTotal); ?></td>
                <td align="center"><?php echo number_format($pfTotal); ?></td>
            </tfoot>
        </table>

        <canvas id="myChart" style="width: 100%; height: 300;"></canvas>

        <script>
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        <?php
                        foreach ($proNameArr as $value) {
                            echo '"' . $value . '",';
                        }
                        ?>
                    ],
                    datasets: [{
                        label: '# กำไร',
                        data: [
                            <?php
                            foreach ($profitArr as $value) {
                                echo $value . ",";
                            }
                            ?>
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>
    </center>
</body>

</html>