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
        var lastId = 0;
        var updateId = 0;

        function setLastId(id) {
            lastId = id;
        }

        // ตั่งค่า Component ใน Dialog
        $(function() {

            // Spinner
            var addCost = $("#addCost").spinner();
            addCost.spinner("enable");

            var addPrice = $("#addPrice").spinner();
            addPrice.spinner("enable");

            var addInventory = $("#addInventory").spinner();
            addInventory.spinner("enable");

            var editCost = $("#editCost").spinner();
            editCost.spinner("enable");

            var editPrice = $("#editPrice").spinner();
            editPrice.spinner("enable");

            var editInventory = $("#editInventory").spinner();
            editInventory.spinner("enable");

            // Add Dialog
            $("#addDialog").dialog({
                autoOpen: false
            });

            // Edit Dialog
            $("#editDialog").dialog({
                autoOpen: false
            });
        });

        // แสดง Add Dialog
        function showAddDialog() {
            $("#addDialog").dialog({
                modal: true,
                autoOpen: true,
                width: 450
            });

            $("#addProduct").val('');
            $("#addCost").val(1);
            $("#addPrice").val(1);
            $("#addInventory").val(1);
            $("#addErr").text('');
        }

        // แสดง Edit Dialog
        function showEditDialog(id) {
            $("#editDialog").dialog({
                modal: true,
                autoOpen: true,
                width: 450
            });

            updateId = id;

            $("#editProduct").val($("#product" + id).text());
            $("#editCost").val($("#cost" + id).text());
            $("#editPrice").val($("#price" + id).text());
            $("#editInventory").val($("#inventory" + id).text());
            $("#editErr").text('');
        }

        // แทรกข้อมูลจาก Add Dialog ลงในตาราง
        function addRow() {
            var categoryId = $("#addCategory").val();
            var product = $("#addProduct").val();
            var cost = $("#addCost").val();
            var price = $("#addPrice").val();
            var inventory = $("#addInventory").val();
            if (product.length !== 0 && cost.length !== 0 && price.length !== 0 && inventory !== 0) {
                lastId = lastId + 1;

                // แทรกข้อมูลในตาราง
                $("#categoryTb tbody").append(
                    '<tr id="row' + lastId + '">' +
                    '   <td align="center">' + lastId + '</td>' +
                    '   <td><label id="category' + lastId + '">' + $("#addCategory option:selected").text() + '</label></td>' +
                    '   <td><label id="product' + lastId + '">' + product + '</label></td>' +
                    '   <td align="center"><label id="cost' + lastId + '">' + cost + '</label></td>' +
                    '   <td align="center"><label id="price' + lastId + '">' + price + '</label></td>' +
                    '   <td align="center"><label id="inventory' + lastId + '">' + inventory + '</label></td>' +
                    '   <td><button onclick="showEditDialog(' + lastId + ');"><span class="ui-icon ui-icon-pencil">แก้ไข</span></button></td>' +
                    '   <td><button onclick="removeRow(' + lastId + ');"><span class="ui-icon ui-icon-trash">ลบ</span></button></td>' +
                    '</tr>');
                    
                // ปิด Diglog
                $("#addDialog").dialog("close");

                // แทรกข้อมูลจาก Add Dialog ลงในฐานข้อมูล
                $.ajax({

                    type: "POST",
                    url: "add.php",
                    data: {
                        productIdForm: lastId,
                        categoryIdForm: categoryId,
                        productForm: product,
                        costForm: cost,
                        priceForm: price,
                        inventoryForm: inventory
                    }
                }).done(function(msg) {
                    //alert( "Data Saved: " + msg );
                });
            } else {
                $("#addErr").text('กรอกข้อมูลไม่ครบ');
            }
        }

        function updateRow() {
            var product = $("#editProduct").val();
            var cost = $("#editCost").val();
            var price = $("#editPrice").val();
            var inventory = $("#editInventory").val();

            // เปลี่ยนข้อมูลในตาราง
            $("#product" + updateId).text(product);
            $("#cost" + updateId).text(cost);
            $("#price" + updateId).text(price);
            $("#inventory" + updateId).text(inventory);

            // ปิด Dialog
            $("#editDialog").dialog("close");

            // เปลี่ยนแปลงข้อมูลในฐานข้อมูล
            if (product.length !== 0 && cost.length !== 0 && price.length !== 0 && inventory !== 0) {
                $.ajax({
                    type: "POST",
                    url: "update.php",
                    data: {
                        idForm: updateId,
                        productForm: product,
                        costForm: cost,
                        priceForm: price,
                        inventoryForm: inventory
                    }
                }).done(function(msg) {
                    //alert( "Data Saved: " + msg );
                });

            } else {
                $("#editErr").text('กรอกข้อมูลไม่ครบ');
            }
        }

        // ลบแถว
        function removeRow(id) {
            $('#row' + id).remove();

            // ลบแถวในฐานข้อมูล
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: {
                    idForm: id
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

    <div id="addDialog" title="เพิ่มสินค้าใหม่">
        <center><label id="addErr" style="color: red;" id="editErr">กรอกข้อมูลไม่ครบ</label></center>
        <center>
            <table border="0" cellspace="5" cellpadding="5">
                <tr>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">ประเภทสินค้า</label>
                    </td>
                    <td colspan="3">

                        <select id="addCategory" class="text ui-widget">
                            <?php
                            $sql = "SELECT category_id, `name`, comment FROM category";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row  
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <option value="<?php echo $row["category_id"] ?>"><?php echo $row["name"] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="text ui-widget">ขื่อสินค้า</label>
                    </td>
                    <td colspan="3">
                        <input id="addProduct" type="text" class="ui-widget ui-corner-all" style="width: 100%;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">ราคาต้นทุน</label>
                    </td>
                    <td>
                        <input id="addCost" value="1" size="2"></input>
                    </td>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">ราคาขาย</label>
                    </td>
                    <td>
                        <input id="addPrice" value="1" size="2"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">จำนวน</label>
                    </td>
                    <td>
                        <input id="addInventory" value="1" size="2"></input>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4">
                        <button class="ui-button ui-widget ui-corner-all" onclick="addRow();">
                            ตกลง <span class="ui-icon ui-icon-disk"></span>
                        </button>
                    </td>
                </tr>
            </table>
        </center>
    </div>

    <div id="editDialog" title="แก้ไขสินค้า">
        <center><label id="editErr" style="color: red;" id="editErr">กรอกข้อมูลไม่ครบ</label></center>
        <center>
            <table border="0" cellspace="5" cellpadding="5">
                <tr>
                    <td>
                        <label class="text ui-widget">ขื่อสินค้า</label>
                    </td>
                    <td colspan="3">
                        <input id="editProduct" type="text" class="ui-widget ui-corner-all" style="width: 100%;"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">ราคาต้นทุน</label>
                    </td>
                    <td>
                        <input id="editCost" value="1" size="2"></input>
                    </td>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">ราคาขาย</label>
                    </td>
                    <td>
                        <input id="editPrice" value="1" size="2"></input>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="text ui-widget" style="white-space: nowrap;">จำนวน</label>
                    </td>
                    <td>
                        <input id="editInventory" value="1" size="2"></input>
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="4">
                        <button class="ui-button ui-widget ui-corner-all" onclick="updateRow();">
                            ตกลง <span class="ui-icon ui-icon-disk"></span>
                        </button>
                    </td>
                </tr>
            </table>
        </center>
    </div>

    <center>
        <h3>สินค้า</h3>
        <br>
    </center>
        

    <div style="height:20px; display:block;" />
    <center>

        <input value="เพิ่มสินค้าใหม่" type="button" class="btn btn-primary d-grid gap-2" onClick="showAddDialog()" />
        <br />


        <br />
        <div style="height:20px; display:block;" />
        <table id="categoryTb" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
            <thead class="ui-widget-header">
                <tr>
                    <th>
                        รหัสสินค้า
                    </th>
                    <th>
                        ประเภท
                    </th>
                    <th>
                        สินค้า
                    </th>
                    <th>
                        ราคาทุน
                    </th>
                    <th>
                        ราคาขาย
                    </th>
                    <th>
                        คงเหลือ
                    </th>
                    <th>
                        แก้ไข
                    </th>
                    <th>
                        ลบ
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT product.product_id AS product_id, category.`name` AS category, \n
                product.`name` AS product, product.cost AS cost, product.price as price, \n
                product.inventory AS inventory \n
                FROM product \n
                INNER JOIN category ON (product.category_id = category.category_id) ORDER BY product.product_id ASC;";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr id="row<?php echo $row["product_id"] ?>">
                            <td align="center">
                                <?php echo $row["product_id"] ?>
                            </td>
                            <td>
                                <label id="category<?php echo $row["product_id"] ?>">
                                    <?php echo $row["category"] ?>
                                </label>
                            </td>
                            <td>
                                <label id="product<?php echo $row["product_id"] ?>"><?php echo $row["product"] ?></label>
                            </td>
                            <td align="center">
                                <label id="cost<?php echo $row["product_id"] ?>"><?php echo $row["cost"] ?></label>
                            </td>
                            <td align="center">
                                <label id="price<?php echo $row["product_id"] ?>"><?php echo $row["price"] ?></label>
                            </td>
                            <td align="center">
                                <label id="inventory<?php echo $row["product_id"] ?>"><?php echo $row["inventory"] ?></label>
                            </td>
                            <td>
                                <button class="btn btn-outline-warning" onclick="showEditDialog(<?php echo $row["product_id"] ?>);">
                                    <span class="ui-icon ui-icon-pencil">แก้ไข</span></button>
                            </td>
                            <td>
                                <button class="btn btn-outline-danger" onclick="removeRow(<?php echo $row["product_id"] ?>);">
                                    <span class="ui-icon ui-icon-trash">ลบ</span></button>
                            </td>
                        </tr>
                <?php
                        $lastId = $row["product_id"];
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <?php
        echo '<script>';
        echo 'setLastId(' . $lastId . ');';
        echo '</script>';
        ?>

    </center>
</body>

</html>