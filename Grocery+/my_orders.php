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
    $username = $_SESSION['username'];
    $sql = "SELECT * from user_order as od where od.email_id = '$username' ";
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
      <table class="table table-bordered table-hover table_background">
            <thead>
              <tr>
                <td>Sr. No</td>
                <td>Order ID</td>
                <td>Order Status</td>
                <td>Ordered on</td>
                <td>Order details</td>
                <td>Cancel order</td>
              </tr>
            </thead>
            <tbody>
              <?php 
                if ($result->num_rows > 0) {
                  $cnt=1;
                  while($row = $result->fetch_assoc()) {
                    $val=$row["order_id"];
                    $link = "order.php?orderID=".$val; 
                    //if(isset($_POST['sub'])){
                      $link1="delete_order.php?orderid=".$val;
                      // $sql1 = "DELETE FROM order_product WHERE order_id='$id'";
                      // $conn->query($sql1);
                      // if ($conn->query($sql1) === TRUE) {
                      //   echo "Record deleted successfully";
                      // } else {
                      //   echo "Error deleting record: " . $conn->error;
                      // }
                      // $sql2 = "DELETE FROM user_order WHERE order_id='$id'";
                      // $conn->query($sql2);
                      // $sql3 = "DELETE FROM order_delivery_man WHERE order_id='$id'";
                      // $conn->query($sql3);
                    //}
              ?>
              <tr><td><?php  echo $cnt ?></td><td> <?php echo $row["order_id"] ?> </td><td> <?php echo $row["order_status"] ?></td><td> <?php echo $row["ordered_on"] ?> </td><td><a href=<?php echo $link ?>><button class="button" name="submit">show detalis</button></a> </td><td><a  href= <?php echo $link1 ?>><button class="button">delete order</button></a></td></tr>;
                    <?php $cnt++; 
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
