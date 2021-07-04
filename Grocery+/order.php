<!DOCTYPE html>
<?php
@ob_start();
session_start();
?>
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
    $conn = OpenCon();
    if (!isset($_SESSION['username'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: user_login.php');
    }
    if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['username']);
      unset($_SESSION['name']);
      header("location: user_login.php");
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
                <?php echo $_SESSION['username'] ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="user_page.php" aria-hidden = true>Profile</a>
                <a class="dropdown-item" href="my_orders.php" aria-hidden = true>My Orders</a>
                <a class="dropdown-item" href="user_login.php?logout='1'" aria-hidden = true>Log Out</a>
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
                <td>Product ID</td>
                <td>Product Name</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Offer Name</td>
                <td>Total Price(Including Offer)</td>
              </tr>
            </thead>
            <tbody>
               <?php 
                $orderID = $_GET['orderID'];
                $sql1 = "SELECT * from order_product as od where od.order_id = '$orderID' ";
                $result1 = $conn->query($sql1);
                $total_cost=0;
                if ($result1->num_rows > 0) {
                  while($row = $result1->fetch_assoc()) {
                    $prod=$row["product_id"];
                    $sql3 = "SELECT * from product as p where p.product_id = '$prod' ";
                    $result3 = $conn->query($sql3);
                    $row2 = $result3->fetch_assoc();
                    $sql2 = "SELECT * from offer_product as op where op.product_id = '$prod' ";
                    $result2 = $conn->query($sql2);
                    $row1 = $result2->fetch_assoc();
                    $offer = $row1["offer_id"];
                    $sql4 = "SELECT * from offer as off where off.offer_id = '$offer' ";
                    $result4 = $conn->query($sql4);
                    $row3 = $result4->fetch_assoc();
                    if($result2->num_rows > 0){
                      $cost = $row["quantity"]*($row2["price"])*((100-$row3["percentage"])/100);  
                      echo '<tr>'.'<td>' . $row["product_id"]. " </td>".'<td>' . $row2["name"]. " </td>"." </td>".'<td>' . $row["quantity"]. " </td>".'<td>' . $row2["price"]. " </td>" .'<td>' . $row3["offer_name"]. " </td>".'<td>' . $cost. " </td>".'</tr>';
                      $total_cost += $cost;
                    }
                    else{
                      $cost = $row["quantity"]*($row2["price"]);
                      echo '<tr>'.'<td>' . $row["product_id"]. " </td>".'<td>' . $row2["name"]. " </td>"." </td>".'<td>' . $row["quantity"]. " </td>".'<td>' . $row2["price"]. " </td>" .'<td>' . "No offers". " </td>".'<td>' . $cost. " </td>".'</tr>';  
                      $total_cost += $cost;
                    }
                  }
                } else {
                  echo "0 results";
                }
              ?>

             </tbody>
           </table>
           <div class="content-section">
              <p class="product_details">Order Price(Rupees) = <?php echo $total_cost; ?></p>
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
