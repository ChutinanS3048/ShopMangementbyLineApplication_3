<?php
session_start();
?>

<!doctype html>
<html>



  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ตรวจสอบการเข้าสู่ระบบ</title>

  <link rel="stylesheet" href="resources/js/jquery-ui-themes-1.12.1/themes/<?php include 'resources/config/theme_name.php'; ?>/jquery-ui.css">

  <script src="resources/js/jquery-1.12.4.js"></script>

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
  

  <script>
    function authen() {

      /*
      $.ajax({
        type: "POST",
        url: "index.php",
        data: {
          userForm: $("#user").val(),
          passwordForm: $("#password").val()
        }
      }).done(function(msg) {
        alert("Data Saved: " + msg);
      });
      */

      /*
      $.ajax({
        type: "POST",
        url: "index.php",
        data: {
          userForm: $("#user").val(),
          passwordForm: $("#password").val()
        },
        success: function(data) {
          //$('.center').html(data);
        }
      });
*/

    }
  </script>

 
</head>

<body>
  <div style="height:20px; display:block;" />

  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="zoom-in" data-aos-delay="200">
          <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-up" data-aos-delay="200">
          <h1>Welcome to, Small Shop Management !</h1>
          <br>
          <br>
          <br>
          <h2 class="text-center"> ตรวจสอบการเข้าสู่ระบบ  </h2>

          <center>
    
    <div class="text ui-widget-header ui-corner-all" style=" width:400px;">
      <div style="display: table-cell; height:40px; vertical-align:middle;">
        กรุณากรอกชื่อผู้ใช้ และรหัสผ่าน
      </div>


      <div class="ui-widget-content">

       


        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <table border="0" cellpadding="6" cellspacing="6">
            <tr>
              <td><label for="user" class="text ui-widget">ชื่อผู้ใช้</label></td>
              <td><input type="text" name="user" class="ui-widget ui-corner-all"></td>
            </tr>
            <tr>
              <td><label for="password" class="text ui-widget">รหัสผ่าน</label></td>
              <td><input type="password" name="password" class="ui-widget ui-corner-all"></td>
            </tr>
            <tr>
              <td colspan="2" align="center">
                <input type="submit" name="submit" value="ตกลง" class="btn btn-primary d-grid gap-2">
              </td>
            </tr>
          </table>
        </form>

      </div>
    </div>







        </div>
        
      </div>
    </div>


  </section><!-- End Hero -->
  
  <?php

if (isset($_POST['submit'])) {

  $login_user = $_POST['user'];
  $login_password = $_POST['password'];

  include 'resources/config/database.php';

  $sql = "SELECT * FROM admin WHERE email='" .  $login_user . "' AND password = '" . $login_password . "';";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
      $_SESSION["first_name"] =  $row['first_name'];
      $_SESSION["last_name"] =  $row['last_name'];
      $_SESSION["email"] =  $row['email'];
      $_SESSION["level"] =  $row['level'];
    }
  } else {
    echo '<script>alert("ชื่อหรือรหัสผ่าน ไม่ถูกต้อง")</script>';
    //echo '<br/><center><label style="color: red; margin-top: 10px;">ชื่อหรือรหัสผ่าน ไม่ถูกต้อง</label></center>';
  }

  $conn->close();

  header("refresh: 2; url=/shop/welcome");
  exit(0);
}

?>



  <?php

  /*

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["userForm"];
    $category = $_POST["passwordForm"];

    echo "Fuck";

  include 'resources/config/database.php';
  $sql = "UPDATE category SET `name`='".$category."', comment='".$comment."' WHERE category_id ='".$id."';";

  if ($conn->query($sql) === TRUE) {
    $conn->close();
    //header( "refresh: 2; url=/shop/category" );
    //exit(0); 
  } else {
    echo "Error deleting record: " . $conn->error;
  }
  $conn->close();


    header("refresh: 2; url=/shop/category");
    exit(0);
  } else {
    //header( "refresh: 2; url=/shop/category" );
    //exit(0);  
  }
*/

  ?>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>