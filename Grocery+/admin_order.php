<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" >
  <link rel="stylesheet" href="styles/template_style.css">
  <link rel="stylesheet" href="styles/user_pg.css">
  <title>Document</title>
</head>
<body>
   <?php
    include 'db_connection.php';
    session_start();
    $conn = OpenCon();
    // Login USER
    if (!isset($_SESSION['ad_name'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: admin_login.php');
    }
    if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['ad_name']);
      header("location: admin_login.php");
    }
    $sql = "SELECT * from user_order ";
    $result = $conn->query($sql);
  ?>
  <div class="container-fluid">
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
      <h2 class = "dispaly-5 logo">GROCERY+</h2>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class= "navbar-nav mr-auto">

        </ul>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle" aria-hidden = true></i>
                Admin
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="admin_order.php" aria-hidden = true>Orders</a>
                <a class="dropdown-item" href="assign.php" aria-hidden = true>Delivery Man list</a>
                <a class="dropdown-item" href="add_delivery_man.php" aria-hidden = true>Add Delivery Man</a>
                <a class="dropdown-item" href="admin_login.php?logout='1'" aria-hidden = true>Log Out</a>
              </div>
            </div>
          <div>
        </div>
      </div>
    </nav>

    <div class="container">
      <table class="table table-bordered table-hover table_background">
            <thead>
              <tr>
                <td>Sr. No</td>
                <td>Order ID</td>
                <td>Order Status</td>
                <td>Ordered on</td>
                <td>Customer City</td>
              </tr>
            </thead>
            <tbody>
              <?php 
                if ($result->num_rows > 0) {
                  $cnt=1;
                  while($row = $result->fetch_assoc()) {
                    if($row["order_status"]=="CONFIRMED"){
                      $user = $row["email_id"];
                      $sql1 = "SELECT city from user where user.email_id='$user'";
                      $result1 = $conn->query($sql1);
                      $row1 = $result1->fetch_assoc();
                      echo '<tr>'.'<td>' .$cnt. " </td>".'<td>' . $row["order_id"]. " </td>".'<td>' . $row["order_status"]. "</td>".'<td>' . $row["ordered_on"]. " </td>".'<td>' . $row1["city"]. " </td>".'</tr>';
                      $cnt++;
                    }
                  }
                }
              ?>
             </tbody>
           </table>
    </div>

    <!-- FOOTER  -->
    <div class="row">
      <div class="col-12 text-center footer">
        CopyRight @ Group - 22 ( DBMS PROJECT )
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</html>
