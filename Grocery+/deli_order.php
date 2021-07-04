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
    if (!isset($_SESSION['del_username'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: delivery-man_login.php');
    }
    if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['del_username']);
      unset($_SESSION['del_name']);
      header("location: delivery-man_login.php");
    }
    $username = $_SESSION['del_username'];
    $sql = "SELECT * from order_delivery_man as od where od.email_id = '$username' ";
    $result = $conn->query($sql);
  ?>
  <div class="container-fluid">
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="#">
        <h2 class = "dispaly-5 logo">GROCERY+</h2>
      </a>

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
                Delivery Man
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="delivery_man_profile.php" aria-hidden = true>Profile</a>
                <a class="dropdown-item" href="deli_order.php" aria-hidden = true>My Orders</a>
                <a class="dropdown-item" href="delivery-man_login.php?logout='1'" aria-hidden = true>Log Out</a>
              </div>
            </div>
          <div>
        </div>
      </div>
    </nav>

    <div class="container">
      
        <div class="row justify-content-center tableHeight" >
        <div class="col align-self-center">
          <table class="table table-bordered table-hover table_background">
            <thead>
              <tr>
                <td>Order ID</td>
                <td>Order Status</td>
                <td>Salary</td>
                <td>Customer details</td>
                <td>Delivery status</td>
              </tr>
            </thead>
            <tbody>
              <?php 
                $total_salary=0;
                if ($result->num_rows > 0) {
                  while($row = $result->fetch_assoc()) {
                    $ord_id = $row["order_id"];
                    $sql1 = "SELECT * from user_order as ord where ord.order_id = '$ord_id' ";
                    $result1 = $conn->query($sql1);
                    $row1 = $result1->fetch_assoc();
                    $total_salary += $row["order_salary"];
                    $link = "user_details.php?orderid=".$ord_id;
                    $link1 = "delivery_status_change.php?orderid=".$ord_id;
                    if($row1["order_status"]=="CONFIRMED" or $row1["order_status"]=="DELIVERING")
                    {
                      echo '<tr>'.'<td>' . $row["order_id"]. " </td>".'<td>' . $row1["order_status"]. " </td>".'<td>' . $row["order_salary"]. " </td>" ?><td><a href=<?php echo $link ?>><button class="button" name="submit">show detalis</button></a> </td><td><a href=<?php echo $link1 ?> ><button class="button" name="submit">delivered</button></a> </td></tr><?php
                    }
                    else{
                      echo '<tr>'.'<td>' . $row["order_id"]. " </td>".'<td>' . $row1["order_status"]. " </td>".'<td>' . $row["order_salary"]. " </td>" .'<td>' .'<button class="btn danger" disabled>show detalis</button>'. " </td>".'<td>' .'<button class="btn danger" disabled>delivered</button>'. " </td>".'</tr>';
                    }
                    
                  }
                } 
              ?>
             </tbody>
           </table>
           <div class="content-section">
              <p class="product_details">Total Salary(Rupees) = <?php echo $total_salary; ?></p>
           </div> 
        </div>  
      
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
