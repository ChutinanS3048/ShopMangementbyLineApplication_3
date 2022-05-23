<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html>

<head>
    <title>เบิกสินค้า</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../resource/jquerymobile/jquery.mobile-1.4.5.min.css" />
    <script src="../resource/jquerymobile/jquery-1.12.4.js"></script>
    <script src="../resource/jquerymobile/jquery.mobile-1.4.5.min.js"></script>

    <script>
        var lineId = <?php echo  "'" . $_GET["user"] . "'" ?>;
        var selectId;
        var selectName;
        var selectAmount;
        var selectPrice;
        var selectData = [];

        // จำนวนสินค้าคงคลังปัจจุบัน
        var price;
        var inventory;

        // ราคาที่สั่งทั้งหมด
        var total = 0;

        $(function() {
            $("#selectOverDiv").hide();
        });

        function setLineId(id) {
            lineId = id;
        }

        function openDialog(id, p, inv) {

            inventory = inv;
            price = p;

            $("#productSelectText").text($("#productName" + id).text());

            $("#productSelectId").val(id);

            $("#amount").val(1);

            $("#amount").attr({
                "max": inventory,
                "min": 1
            });

            $("#overSelectText").text('');

            $("#selectDialog").popup("open");
        }

        function addCart() {
            // แจ้งเตือนเมื่อเลือกสินค้าเกินสต็อก
            if (inventory < $("#amount").val()) {
                $("#overSelectText").text('เลือกสินค้าเกินจำนวนที่มีอยู่');
            } else {

                var dupId = false;
                var dubIndex = 0;

                // ค้นหา prouct ID ว่า ซ้ำหรือไม่
                for (var i = 0; i < selectData.length; i++) {
                    if (selectData[i].selectId === $("#productSelectId").val()) {
                        dupId = true;
                        dupIndex = i;
                    }
                }

                // ถ้าเคยเลือกไปแล้วให้เปลี่ยนแปลง เฉพาะจำนวน
                if (dupId) {
                    selectData[dupIndex].selectAmount = $("#amount").val();
                } else {

                    // ถ้าไม่เคยเลือกให้เพิ่มเข้าไปใหม่ใน Array
                    selectData.push({
                        selectId: $("#productSelectId").val(),
                        selectName: $("#productSelectText").text(),
                        selectAmount: $("#amount").val(),
                        selectPrice: price
                    });
                }
                $("#selectDialog").popup("close");
                $("#selectOverDiv").show();
                $("#selectCount").text('เลือกสินค้าไว้ ' + selectData.length + ' รายการ');
            }

        }

        function removeCart(id) {

            var deleteIndex;

            // ค้นหา Array Index ที่ต้องการลบ
            for (var i = 0; i < selectData.length; ++i) {
                if (id == selectData[i].selectId) {
                    deleteIndex = i;
                    total = total - (selectData[i].selectAmount * selectData[i].selectPrice);
                }
            }

            $('#proId' + id).remove();

            selectData.splice(deleteIndex, 1);

            // ถ้าลบออกหมด ให้ถอยกลับไป
            if (selectData.length == 0) {
                $("#selectOverDiv").hide();
                $("#selectCount").text('ยังไม่ได้เลือกสินค้า');
                $(location).attr('href', '#productPage');
                total = 0;
            } else {
                $("#total").text('รวมทั้งสิ้น ' + totaltoString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' บาท');
                $("#selectCount").text('เลือกสินค้าไว้ ' + selectData.length + ' รายการ');
            }
        }

        function previewSelect() {

            for (var i = 0; i < selectData.length; ++i) {
                $("#productSelectList tbody").append(
                    '<tr id="proId' + selectData[i].selectId + '">' +
                    '	<td><label>' + selectData[i].selectName + '</label></td>' +
                    '	<td><label>' + selectData[i].selectAmount + '</label></td>' +
                    '	<td><label>' + selectData[i].selectPrice + '</label></td>' +
                    '	<td><label>' + selectData[i].selectAmount * selectData[i].selectPrice + '</label></td>' +
                    '   <td><a href="#" onclick="removeCart(' + selectData[i].selectId + ');" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-icon-delete ui-btn-icon-right" data-theme="a">ลบ</a></td>' +
                    '</tr>');
                total = total + (selectData[i].selectAmount * selectData[i].selectPrice);
            }
            $(location).attr('href', '#selectListPage');

            $("#total").text('รวมทั้งสิ้น ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' บาท');

        }

        function backToMainPage() {
            // ลบตารางออกทั้งหมด
            for (var i = 0; i < selectData.length; ++i) {
                $('#proId' + selectData[i].selectId).remove();
            }
            $(location).attr('href', '#productPage');
        }

        function createInvoice() {
            var arrId = [];
            var arrQ = [];

            for (var i = 0; i < selectData.length; ++i) {
                arrId[i] = selectData[i].selectId;
                arrQ[i] = selectData[i].selectAmount;
            }

            $.ajax({
                type: "POST",
                url: "create_invoice.php",
                data: {
                    lineIdForm: lineId,
                    proIdForm: arrId,
                    quantityForm: arrQ
                }
            }).done(function(msg) {
                //alert("Data Saved: " + msg);
                $(location).attr('href', 'complete.php');
            });
        }
    </script>
</head>

<body>

    <?php
    /*
    echo '<script>';
    echo "setLineId('" . $_GET["user"] . "');'";
    echo '</script>';
    */
    ?>

    <div data-role="page" id="productPage">
        <div data-role="popup" id="selectDialog" data-overlay-theme="a" data-theme="a" data-dismissible="false" style="width:100%;">
            <div data-role="header" data-theme="a">
                <h1>ระบุจำนวน</h1>
            </div>
            <div role="main" class="ui-content" style="text-align: center;">
                <label id="productSelectText"></label>
                <label id="overSelectText" style="color: red; font-weight: bold;"></label>
                <p>
                <div class="ui-field-contain">
                    <label for="amout">จำนวน</label>
                    <input id="amount" type="number" max="???" min="???" step="1" style="text-align: right;" data-clear-btn="true" data-mini="true" pattern="[0-9]*" />
                    <input type="hidden" id="productSelectId" />
                </div>
                </p>
                <button class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" onclick="addCart();">ตกลง</button>                
                <a href="#" class="ui-btn ui-corner-all ui-shadow ui-btn-inline ui-btn-b" data-rel="back">ยกเลิก</a>
            </div>
        </div>

        <div data-role="header" data-position="fixed" class="ui-bar">
            <h1>เบิกสินค้า</h1>
            <div style="text-align: center; margin-top: 3px;">
                <label id="selectCount" style="color: red;">ยังไม่ได้เลือกกสินค้า</label>
            </div>
            <div id="selectOverDiv" data-position="fixed" style="text-align: center; margin-top: 2px;">
                <a href="#" onclick="previewSelect();" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-icon-eye ui-btn-icon-right" data-theme="b">ดูสินค้าที่เลือก</a>
            </div>
        </div>

        <div role="main" class="ui-content">
            <p>
            <table data-role="table" class="ui-body-d ui-shadow table-stripe ui-responsive">
                <thead>
                    <tr>
                        <th>สินค้า</th>
                        <th>รหัส</th>
                        <th>จำนวนสินค้าคงคลัง</th>
                        <th>ราคา</th>
                        <th>เลือกสินค้า</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include '../../resources/config/database.php';

                    $sql = "SELECT product_id, `name`, price, inventory FROM shop.product WHERE inventory > 0 ORDER BY product_id DESC;";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td>
                                    <label id="productName<?php echo $row["product_id"]; ?>"><?php echo $row["name"]; ?></label>
                                </td>
                                <td>
                                    <label><?php echo $row["product_id"]; ?></label>
                                </td>
                                <td>
                                    <label><?php echo $row["inventory"]; ?></label>
                                </td>
                                <td>
                                    <label><?php echo $row["price"]; ?></label>
                                </td>
                                <td>
                                    <button class="ui-btn ui-shadow ui-corner-all ui-icon-shop ui-btn-icon-right" onclick="openDialog(<?php echo $row["product_id"]; ?>, <?php echo $row["price"]; ?>, <?php echo $row["inventory"]; ?>);">ตกลง</button>
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
        </div>

        <div data-role="footer" data-position="fixed" class="ui-bar">
            <h4>Shop Management</h4>
        </div>
    </div>

    <div data-role="page" id="selectListPage">

        <div data-role="header">
            <h1>สรุปรายการที่เลือก</h1>
        </div>

        <div role="main" class="ui-content">
            <table id="productSelectList" data-role="table" class="ui-body-d ui-shadow table-stripe ui-responsive">
                <thead>
                    <tr>
                        <th>ชื่อสินค้าที่เลือก</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย</th>
                        <th>ราคารวม</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <p style="text-align: center;">
                <label id="total" style="font-weight: bold;">รวมทั้งสิ้น 2000 บาท</label>
            </p>
            <p style="text-align: center;">
                <a href="#" onclick="backToMainPage();" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-icon-back ui-btn-icon-right" data-theme="b">กลับไปเลือกสินค้าต่อ</a>
                <a href="#" onclick="createInvoice();" class="ui-btn ui-btn-inline ui-shadow ui-corner-all ui-icon-check ui-btn-icon-right" data-theme="b">เสร็จสิ้น</a>
            </p>
        </div>

        <div data-role="footer" data-position="fixed" class="ui-bar">
            <h4>Shop Management</h4>
        </div>

    </div>


</body>

</html>
