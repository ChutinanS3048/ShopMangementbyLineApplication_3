<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../resources/config/database.php';

$sql = "SELECT COUNT(line_id) FROM shop.partner WHERE line_id ='" . $_GET['user'] . "';";
$result = $conn->query($sql);
$row = $result->fetch_row();

if ($row[0] != 0) {
	$conn->close();
	header( "refresh: 2; url=/shop/mobile/register/register_deny.php" );
	exit(0);
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>ลงทะเบียนผู้ใช้ใหม่</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="../resource/jquerymobile/jquery.mobile-1.4.5.min.css" />
	<script src="../resource/jquerymobile/jquery-1.12.4.js"></script>
	<script src="../resource/jquerymobile/jquery.mobile-1.4.5.min.js"></script>

	<script>
		var lineId = <?php echo  "'" . $_GET["user"] . "'" ?>;

		$(function() {
			$("#addErr").text('');
		});

		function setLineId(id) {
			lineId = id;
		}

		function addUser() {
			var firstName = $("#firstName").val();
			var lastName = $("#lastName").val();
			var nickName = $("#nickName").val();
			var address = $("#address").val();
			var subDistrict = $("#subDistrict").val();
			var district = $("#district").val();
			var province = $("#province").val();
			var zipcode = $("#zipcode").val();
			var mobile = $("#mobile").val();
			var email = $("#email").val();

			if (firstName.length !== 0 && lastName.length !== 0 && nickName.length !== 0 && address.length !== 0 && subDistrict.length !== 0 && district.length !== 0 && province.length !== 0 && zipcode.length !== 0 && mobile.length !== 0 && email.length !== 0) {
				$.ajax({
					type: "POST",
					url: "add_user.php",
					data: {
						firstNameForm: firstName,
						lastNameForm: lastName,
						nickNameForm: nickName,
						addressForm: address,
						subDistrictForm: subDistrict,
						districtForm: district,
						provinceForm: province,
						zipcodeForm: zipcode,
						mobileForm: mobile,
						emailForm: email,
						lineIdForm: lineId
					}
				}).done(function(msg) {
					//alert("Data Saved: " + msg);
					$(location).attr('href', 'complete.php');
				});
			} else {
				$("#addErr").text('กรอกข้อมูลไม่ครบ');
			}
		}
	</script>

</head>

<body>

	<div data-role="page">

		<div data-role="header" data-position="fixed" class="ui-bar">
			<h1>ลงทะเบียนผู้ใช้ใหม่</h1>
		</div>

		<div role="main" class="ui-content">
			<p>

			<div style="text-align: center; display: block; width: 100%;">
				<label id="addErr" style="color: red;">กรอกข้อมูลไม่ครบ</label>
			</div>

			<div class=" ui-field-contain">

				<label for="firstName">
					ชื่อ:
				</label>
				<input id="firstName" type="text" data-clear-btn="true" data-mini="true" />
				<label for=" lastName" style="margin-top: 8px;">
					นามสกุล:
				</label>
				<input id="lastName" type="text" data-clear-btn="true" data-mini="true" />

				<label for="nickName" style="margin-top: 8px;">
					ชื่อเล่น:
				</label>
				<input id="nickName" type="text" data-clear-btn="true" data-mini="true" />

				<label for="address" style="margin-top: 8px;">
					ที่อยู่ (เลขที่/ซอย/ถนน):
				</label>
				<input id="address" type="text" data-clear-btn="true" data-mini="true" />

				<label for="subDistrcit" style="margin-top: 8px;">
					ตำบล:
				</label>
				<input id="subDistrict" type="text" data-clear-btn="true" data-mini="true" />

				<label for="district" style="margin-top: 8px;">
					อำเภอ:
				</label>
				<input id="district" type="text" data-clear-btn="true" data-mini="true" />

				<label for="province" style="margin-top: 8px;">
					จังหวัด:
				</label>
				<input id="province" type="text" data-clear-btn="true" data-mini="true" />

				<label for="zipcode" style="margin-top: 8px;">
					รหัสไปรษณีย์:
				</label>
				<input id="zipcode" type="number" data-clear-btn="true" data-mini="true" />

				<label for="mobile" style="margin-top: 8px;">
					หมายเลขโทรศัพท์:
				</label>
				<input id="mobile" type="number" data-clear-btn="true" data-mini="true" />

				<label for="email" style="margin-top: 8px;">
					อีเมล์:
				</label>
				<input id="email" type="email" data-clear-btn="true" data-mini="true" />
			</div>
			<br />

			<button class="ui-btn ui-shadow ui-corner-all ui-icon-check ui-btn-icon-right" onclick="addUser();">ตกลง</button>

			<?php
			/*
			echo '<script>';
			echo "setLineId('" . $_GET["user"] . "');'";
			echo '</script>';
			*/
			?>
			</p>
		</div>

		<div data-role="footer" data-position="fixed" class="ui-bar">
			<h4>Shop Management</h4>
		</div>
	</div>
</body>

</html>
