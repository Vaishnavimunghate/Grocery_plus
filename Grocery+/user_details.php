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
                <a class="dropdown-item" href="user_page.php" aria-hidden = true>Profile</a>
                <a class="dropdown-item" href="my_orders.php" aria-hidden = true>My Orders</a>
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
                <td>Customer Name</td>
                <td>Phone number</td>
                <td>Location</td>
                <td>City</td>
                <td>State</td>
                <td>Pincode</td>
              </tr>
            </thead>
            <tbody>
               <?php 
                $orderID = $_GET['orderid'];
                $sql = "SELECT * from user_order as uo where uo.order_id = '$orderID' ";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $userid=$row["email_id"];
                $sql1 = "SELECT * from user as u where u.email_id = '$userid' ";
                $result1 = $conn->query($sql1);
                $row1 = $result1->fetch_assoc();
              
                    if($row1['phone_number']==NULL){
                      echo '<tr>'.'<td>' . $row1["name"]. " </td>".'<td>' . "Not added". " </td>"." </td>".'<td>' . $row1["location"]. " </td>".'<td>' . $row1["state"]. " </td>" .'<td>' . $row1["city"]. " </td>".'<td>' . $row1["pincode"]. " </td>".'</tr>';
            
                    }
                    else{
                      echo '<tr>'.'<td>' . $row1["name"]. " </td>".'<td>' . $row1["phone_number"]. " </td>"." </td>".'<td>' . $row1["location"]. " </td>".'<td>' . $row1["state"]. " </td>" .'<td>' . $row1["city"]. " </td>".'<td>' . $row1["pincode"]. " </td>".'</tr>';                    
                    }
              ?>

             </tbody>
           </table>
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
