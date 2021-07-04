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
  <link rel="stylesheet" href="styles/checkout_page/checkout_page_style.css">
  <title>Document</title>
  <?php
    include "db_connection.php";
    session_start();
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
</head>
<body>

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

      <?php
        $conn = OpenCon();
        //$_SESSION['email_id'] = 'abc@gmail.com';
        $sql_query = "select  A.product_id, A.name, user_cart.quantity, A.price, offer.offer_name, offer.percentage \n"

              . "from user_cart natural join product as A, offer natural join offer_product as B\n"

              . "where user_cart.email_id = ".'\''.$_SESSION['username'].'\''." and A.product_id = B.product_id";

        $result = $conn->query($sql_query);
        $count = 1;
        $cart_price = 0;
      ?>

      <div class="row spaceHeight">
        <br>
      </div>
      <div class="row justify-content-center" >
        <div class="col align-self-center">
          <table class="table table-bordered table-hover table_background">
            <thead>
              <tr>
                <td>S.No</td>
                <td>Product Name</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Offer</td>
                <td>Total Price</td>
              </tr>
            </thead>
            <tbody>
              <?php while ( $row = $result->fetch_assoc() ){ ?>
               <tr>
                  <td data-title="S.No"><?php echo $count?></td>
                 <td data-title="Name"><?php echo $row["name"]?></td>
                 <td data-title="Quantity"><?php echo $row["quantity"] ?></td>
                 <td data-title="price"><?php echo $row["price"] ?></td>
                 <td data-title="offer"><?php echo $row["percentage"]."%" ?></td>
                 <td data-title="Total price">
                    <?php
                      $total_price = $row['price']-$row['price'] * $row['percentage'] / 100;
                      $total_price = $total_price * $row['quantity'];
                      echo $total_price;
                      $count ++;
                      $cart_price += $total_price;
                    ?>
                 </td>
               </tr>
              <?php } ?>
             </tbody>
           </table>
        </div>
      </div>
      <div class="row justify-content-center titleHeight">
        <div class="col-md-4">
          <p class="product_details">Order Price ( Rupees )</p>
        </div>
        <div class="col">
          <p class="product_details"><?php echo "$cart_price" ?>
          </p>
        </div>
      </div>

      <div class="row justify-content-center titleHeight">
        <?php
        $sql1 = "SELECT location,state,city,pincode from user as u where u.email_id = '".$_SESSION['username']."' ";
        $user = $conn->query($sql1);

         ?>
        <div class="col">
          <table class="table table-bordered table-hover offer_table_background">
            <thead>
              <tr>
                <td>Delivery Address</td>
              </tr>
            </thead>
            <tbody>
              <?php while ( $user_row = $user->fetch_assoc() ){ ?>
               <tr>
                  <td data-title="location">location: <?php echo $user_row['location']?></td>
                  <td data-title="state">state: <?php echo $user_row['state']?></td>
                  <td data-title="city">city: <?php echo $user_row['city']?></td>
                  <td data-title="pincode">pincode: <?php echo $user_row['pincode']?></td>
               </tr>
              <?php } ?>
             </tbody>
           </table>

        </div>
      </div>

      <?php
          function generateOrderID($conn)
          {
            // get the max order ID from the user_order mysql_list_tables
            $sql = "select max(order_id) as max_id\n"
                    . "from user_order";
            // $conn = OpenCon();
            $result = $conn->query($sql);
            if($result == false)
              echo "error in sql query";
            $order_count = 0;
            $pre_text = "ORDEROGTID";
            if($result->num_rows > 0)
            {
              $row = $result->fetch_assoc();
              $max_order_id = $row['max_id'];
              $max_order_id = str_replace($pre_text, "0", $max_order_id);
              // echo $max_order_id."\n";
              $order_count = (int)$max_order_id;

            }
            // echo $order_count."\n";

            $order_count ++;
            $new_order_id = str_pad($order_count, 10, '0', STR_PAD_LEFT);
            $new_order_id = $pre_text.$new_order_id;
            return $new_order_id;

          }

          function insertData($conn,$sql_query,$email,$order_price)
          {
             $orderId = generateOrderID($conn);
             //echo $orderId;
             $sql = "insert into order_product(order_id,product_id,quantity) VALUES\n";
             $i = 0;
             // $conn = OpenCon();
             $result = $conn->query($sql_query);
             while ( $row = $result->fetch_assoc() ){
                $new_sql = "	('".$orderId."','".$row['product_id']."',".$row['quantity'].")";
                if ($result->num_rows == $i+1)
                  $new_sql = $new_sql.";\n";
                else
                  $new_sql = $new_sql.",\n";
                $sql .= $new_sql;
                $i++;
             }

             // echo $sql;
            $result = $conn->query($sql);

             if(!$result)
             {
               echo "<script>alert('Unable to insert1! Server busy! Try again');"."document.location.href='order_failure_page.php';</script>";
             }
             else {
               // insert into user_order database
               $sql = "insert into user_order(email_id,order_id,order_status,price) VALUES\n"
                      . '	(\''.$email."','".$orderId."','CONFIRMED',".$order_price.")";
               $result = $conn->query($sql);
               if(!$result)
               {
                 echo "<script>alert('Unable to insert2! Server busy! Try again');"."document.location.href='order_failure_page.php';</script>";
               }
               // delete the cart items for user
               $sql = "delete from user_cart\n"
                      . "where email_id = '".$email."'";
               $result = $conn->query($sql);
               if(!$result)
               {
                echo "<script>alert('Unable to insert! Server busy! Try again');"."document.location.href='order_success_page.php';</script>";
               }

               echo "<script>document.location.href='order_success_page.php';</script>";
             }

          }

          if(array_key_exists('PLACE_ORDER', $_POST)) {
              insertData($conn, $sql_query, $_SESSION['username'], $cart_price);
          }
      ?>
      <br>
      <br>
      <form method ="post">
        <div class="row  justify-content-center miniRowHeight">
          <div class="col-md-10 align-self-center">
            <input class="btn btn-danger btn-lg btn-block" type="submit" name="PLACE_ORDER" value="PLACE ORDER"/>
          </div>
        </div>
      </form>

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
