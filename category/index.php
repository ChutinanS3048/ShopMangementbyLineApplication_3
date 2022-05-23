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
	<title>ประภทสินค้า</title>
	<link rel="stylesheet" href="../resources/js/jquery-ui-themes-1.12.1/themes/<?php include '../resources/config/theme_name.php'; ?>/jquery-ui.css">
	<script src="../resources/js/jquery-1.12.4.js"></script>
	<script src="../resources/js/jquery-ui-1.12.1.custom/jquery-ui.js"></script>

	<script>
		var lastId = 0;
		var updateId = 0;
		var dialog;

		$(function() {
			$("#dialog").dialog({
				modal: true,
				autoOpen: false
			});
		});

		function setLastId(id) {
			lastId = id;
		}

		function showDialog(id) {
			$("#dialog").dialog({
				modal: true,
				autoOpen: true,
				width: 400
			});

			updateId = id;

			$("#categoryEdit").val($("#category" + id).text());
			$("#commentEdit").val($("#comment" + id).text());
			$("#editErr").text('');
		}

		function addRow() {
			var category = $("#categoryText").val();
			var comment = $("#commentText").val();

			if (category.length !== 0 && comment.length !== 0) {
				lastId = lastId + 1;
				$("#categoryTb tbody").append(
					'<tr id="row' + lastId + '">' +
					'	<td align="center">' + lastId + '</td>' +
					'	<td><label id="category' + lastId + '">' + category + '</label></td>' +
					'	<td><label id="comment' + lastId + '">' + comment + '</label></td>' +
					'	<td><button onclick="showDialog(' + lastId + ');"><span class="ui-icon ui-icon-pencil">แก้ไข</span></button></td>' +
					'	<td><button onclick="removeRow(' + lastId + ');"><span class="ui-icon ui-icon-trash">ลบ</span></button></td>' +
					"</tr>");

				$.ajax({
					type: "POST",
					url: "add.php",
					data: {
						categoryForm: category,
						commentForm: comment
					}
				}).done(function(msg) {
					//alert( "Data Saved: " + msg );
				});
				$("#addErr").text('');
				$("#categoryText").val('');
				$("#commentText").val('');
			} else {
				$("#addErr").text('กรอกข้อมูลไม่ครบ');
			}
		}

		function updateRow() {
			if ($("#categoryEdit").val().length !== 0 && $("#commentEdit").val().length !== 0) {

				$.ajax({
					type: "POST",
					url: "update.php",
					data: {
						idForm: updateId,
						categoryForm: $("#categoryEdit").val(),
						commentForm: $("#commentEdit").val()
					}
				}).done(function(msg) {
					//alert( "Data Saved: " + msg );
				});

				$("#category" + updateId).text($("#categoryEdit").val());
				$("#comment" + updateId).text($("#commentEdit").val());

				$("#dialog").dialog("close");

			} else {
				$("#editErr").text('กรอกข้อมูลไม่ครบ');
			}
		}

		function removeRow(id) {
			$('#row' + id).remove();

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

		// ไม่ได้ใช้
		function redirectPost(url, data) {
			var form = document.createElement('form');
			document.body.appendChild(form);
			form.method = 'post';
			form.action = url;
			for (var name in data) {
				var input = document.createElement('input');
				input.type = 'hidden';
				input.name = name;
				input.value = data[name];
				form.appendChild(input);
			}
			form.submit();
		}
	</script>
</head>

<body>

	<?php
	include '../resources/components/menu.php';
	?>

	<div id="dialog" title="แก้ไขข้อมูล">

		<center><label id="editErr" style="color: red;" id="editErr">กรอกข้อมูลไม่ครบ</label></center>

		<form>
			<table border="0" cellpadding="5" cellspacing="5">
				<tr>
					<td>
						ประเภทสินค้า
					</td>
					<td>
						<input id="categoryEdit" type="text" class="ui-widget ui-corner-all" />
					</td>
				</tr>
				<tr>
					<td>
						หมายเหตุ
					</td>
					<td>
						<input id="commentEdit" type="text" class="ui-widget ui-corner-all" />
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2">
						<button class="ui-button ui-widget ui-corner-all" onclick="updateRow();">
							ตกลง <span class="ui-icon ui-icon-disk"></span>
						</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

	<center>
		<h3>ประเภทสินค้า</h3>
	</center>

	<div style="height:20px; display:block;" />
	<center>
		<label id="addErr" style="color: red;"></label>
		<form>
			<table border="0" cellpadding="5" cellspacing="5">
				<tr>
					<td>
						<label class="text ui-widget">ประเภทสินค้า</label>
					</td>
					<td>
						<input id="categoryText" type="text" name="category" class="ui-widget ui-corner-all" />
					</td>
					<td>
						<label class="text ui-widget">หมายเหตุ</label>
					</td>
					<td>
						<input id="commentText" type="text" name="comment" class="ui-widget ui-corner-all" />
					</td>
					<td>
						<input value="เพิ่ม" type="button" class="btn btn-primary d-grid gap-2" onClick="addRow()" />
					</td>
				</tr>
			</table>
		</form>
		<br />
		<?php include '../resources/config/database.php'; ?>
		<div style="height:20px; display:block;" />
		<table id="categoryTb" class="ui-widget ui-widget-content" cellpadding="5" cellspacing="5">
			<thead class="ui-widget-header">
				<tr>
					<th>
						รหัสประเภท
					</th>
					<th>
						ประเภทสินค้า
					</th>
					<th>
						หมายเหตุ
					</th>
					<th>
						แก้ไข</span>
					</th>
					<th>
						ลบ</span>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "SELECT category_id, `name`, comment FROM category";
				$result = $conn->query($sql);

				if ($result->num_rows > 0) {

					while ($row = $result->fetch_assoc()) {
				?>
						<tr id="row<?php echo $row["category_id"] ?>">
							<td align="center">
								<?php echo $row["category_id"] ?>
							</td>
							<td>
								<label id="category<?php echo $row["category_id"] ?>"><?php echo $row["name"] ?></label>
							</td>
							<td>
								<label id="comment<?php echo $row["category_id"] ?>"><?php echo $row["comment"] ?></label>
							</td>
							<td>
								<button class="btn btn-outline-warning" onclick="showDialog(<?php echo $row["category_id"] ?>);"><span class="ui-icon ui-icon-pencil">แก้ไข</span></button>
							</td>
							<td>
								<button class="btn btn-outline-danger" onclick="removeRow(<?php echo $row["category_id"] ?>);"><span class="ui-icon ui-icon-trash">ลบ</span></button>
							</td>
						</tr>
				<?php
						$lastId = $row["category_id"];
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