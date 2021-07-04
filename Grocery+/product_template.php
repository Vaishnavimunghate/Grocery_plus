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
  <link rel="stylesheet" href="styles/product_template/product_template_style.css">
  <title>product_template</title>
  <?php include "db_connection.php" ?>
</head>
<body>
  <?php
  $db = OpenCon();
	#echo "Connected Successfully";

  // Login USER
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

  CloseCon($db);
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

      <?php
        $conn = OpenCon();
        if(isset($_GET["product_id"]))
        {
            $product_id = $_GET["product_id"];
            $sql = "select * from `product` where product_id='".$product_id."'";
            $result = $conn->query($sql);
            if(!$result)
              echo "error";
            $row = mysqli_fetch_array($result);
            $img_src = "data:image/jpeg;base64,".base64_encode( $row['image'] );
        }

      ?>
      <div class="row justify-content-center text-center titleHeight">
        <div class="col align-self-center">
          <h1 class="product_name font-weight-bold" ><?php echo $row['name'] ?></h1>
        </div>
      </div>
      <div class="row rowHeight">
        <div class="col-md-6 align-self-center">
          <img class="img-responsive img-thumbnail" src=<?php echo $img_src ?> alt=<?php echo $row['name'] ?>>
        </div>
        <div class="col-md-6 align-self-center">
          <div class="row justify-content-center miniRowHeight">
            <div class="col-md-5 align-self-center">
                <p class="product_sol font-weight-bold">Price(Rupees)</p>
            </div>
            <div class="col-md-4 align-self-center">
                <button class="btn btn-outline btn-block btn_quantity"><?php echo $row['price'] ?></button>
            </div>
          </div>
          <?php

          function add_to_cart($conn, $query)
          {
            $sql = "insert into user_cart(email_id,product_id,quantity) VALUES\n".$query;

            #echo $sql;
            $result = $conn->query($sql);

            if(!$result)
            {
              $link = 'product_template.php?product_id='.$_GET["product_id"];
              echo "<script>alert('Unable to insert1! Server busy! Try again');"."document.location.href='".$link."';</script>";
            }
            else {
              echo "<script>document.location.href='cart_page.php';</script>";
            }
          }

          function checkout($conn, $query)
          {
            $sql = "insert into user_cart(email_id,product_id,quantity) VALUES\n".$query;

            $result = $conn->query($sql);

            if(!$result)
            {
              $link = 'product_template.php?product_id='.$_GET["product_id"];
              echo "<script>alert('Unable to insert1! Server busy! Try again');"."document.location.href='".$link."';</script>";
            }
            else {
              echo "<script>document.location.href='checkout_page.php';</script>";
            }
          }

          if (isset($_POST['ADD_TO_CART'])) {
             $quantity = $_POST['quantity'];
              $query = "	('".$_SESSION['username']."','".$row['product_id']."',".$quantity.");";
              add_to_cart($conn, $query);
          }

          if(isset( $_POST['CHECKOUT'])) {
              $quantity = $_POST['quantity'];
              $query = "	('".$_SESSION['username']."','".$row['product_id']."',".$quantity.");";
              checkout($conn, $query);
          }
          ?>
          <form name="form" method="post">
          <div class="row justify-content-center miniRowHeight">
            <div class="col-md-5 align-self-center">
                <p class="product_sol font-weight-bold">Quantity</p>
            </div>
            <div class="col-md-4 align-self-center">
                <input type="number" id="quantity" name="quantity" min="1" max=<?php echo '"'.$row['max_quantity'].'"' ?> />
            </div>
          </div>

            <div class="row  justify-content-center miniRowHeight">
              <div class="col-md-10 align-self-center">
                <input class="btn btn-danger btn-lg btn-block" type="submit" name="ADD_TO_CART" value="ADD TO CART"/>
              </div>
            </div>

            <div class="row  justify-content-center miniRowHeight">
              <div class="col-md-10 align-self-center">
                <input class="btn btn-danger btn-lg btn-block" type="submit" name="CHECKOUT" value="CHECKOUT"/>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row justify-content-center tableHeight" >
        <div class="col align-self-center">
          <table class="table table-bordered table-hover table_background">
             <tbody>
               <tr>
                 <td>Brand</td>
                 <td><?php echo $row['brand'] ?></td>
               </tr>
               <tr>
                 <td>Max Orderable Quantity ( 1 order )</td>
                 <td><?php echo $row['max_quantity'] ?></td>
               </tr>
             </tbody>
           </table>
        </div>
      </div>
      <br>
      <div class="row justify-content-center " >
        <div class="col align-self-center">
          <table class="table table-bordered table-hover offer_table_background">
            <thead>
              <tr>
                <td>Offer Name</td>
                <td>Offer Percentage</td>
              </tr>
            </thead>
            <?php
              $sql_query = "select offer_name, percentage\n"

                                  . "from offer natural join offer_product as A\n"

                                  . "where A.product_id = '".$row['product_id']."'";

              $offer_result = $conn->query($sql_query);
            ?>
            <tbody>
              <?php while ( $off_row = $offer_result->fetch_assoc() ){ ?>
               <tr>
                  <td data-title="Name"><?php echo $off_row['offer_name']?></td>
                  <?php
                    if ($off_row['percentage'] == null)
                        $text = "NA";
                    else {
                      $text = $off_row['percentage'];
                    }
                  ?>
                  <td data-title="Percentage"><?php echo $text?></td>
               </tr>
              <?php } ?>
             </tbody>
           </table>
        </div>
      </div>
      <br>
      <div class="row justify-content-center ">
          <div class="col align-self-center">
            <table class="table table-bordered table-hover category_background">
              <thead>
                <tr>
                  <td>Category</td>
                </tr>
              </thead>
              <tbody>
                <?php
                  $cat_query  = "select category\n"

                                . "from product_category\n"

                                . "where product_id = '".$row['product_id']."'";

                  $cat_result = $conn->query($cat_query);
                ?>
                <?php while ( $cat_row = $cat_result->fetch_assoc() ){ ?>
                 <tr>
                    <td data-title="Product_details"><?php echo $cat_row['category']?></td>
                 </tr>
                <?php } ?>
               </tbody>
             </table>
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
<script>
var quantity=0;
function incQuantity() {
  quantity = quantity + 1;
  document.getElementById("quantity").innerHTML = quantity;
}
function decQuantity() {
  quantity = quantity - 1;
  document.getElementById("quantity").innerHTML = quantity;
}
document.getElementById("cart").onclick = function () {
  location.href = "cart_page.php";
};
document.getElementById("checkout").onclick = function () {
  location.href = "checkout_page.php";
};
</script>

</html>
