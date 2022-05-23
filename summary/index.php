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
    <script>
        $(function() {
            $("#startDate").datepicker();
            $("#startDate").datepicker("setDate", "today");
            $("#toDate").datepicker();
            $("#toDate").datepicker("setDate", "today");
        });


        function query() {
            $.ajax({
                type: "GET",
                url: 'result.php?start=' + $("#startDate").val() + '&end=' + $("#toDate").val(),
                success: function(response) {
                    //alert(response);
                    $(location).attr('href', 'result.php?start=' + $("#startDate").val() + '&end=' + $("#toDate").val());
                }
            });
        }

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
                    <button onclick="query();" class="btn btn-primary">
                        ประมวลผล
                        <span class="ui-icon ui-icon-calculator">
                        </span>
                    </button>
                </td>
            </tr>
        </table>

        <br />
        <div style="height:20px; display:block;" />

        </tbody>
        </table>

    </center>
</body>

</html>