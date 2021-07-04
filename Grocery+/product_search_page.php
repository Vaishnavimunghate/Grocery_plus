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
  <link rel="stylesheet" href="styles/product_search_page/product_search_page_style.css">
  <title>Document</title>
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
                <a class="dropdown-item" href="user_login.php>logout=1" aria-hidden = true>Log Out</a>
              </div>
            </div>
          <div>
        </div>
      </div>
    </nav>

    <div class="container">
      <?php
        $conn = OpenCon();
        if(isset($_GET["offer_id"]))
        {
            $offer_id = $_GET["offer_id"];
            $sql = "select  product_id, name, price\n"
                  . "from product natural join offer_product \n"
                  . "where offer_id = \"".$offer_id."\"";
            $result = $conn->query($sql);
        }
        if(isset($_GET["category_id"]))
        {
            $category = str_replace("_"," ",$_GET["category_id"]);
            $sql = "select  product_id, name, price\n"
                  . "from product natural join product_category \n"
                  . "where category = \"".$category."\"";
            $result = $conn->query($sql); ?>
            <h3 style="margin:10px;"> <b> <?php echo "Showing products of the category: ".$category; ?> <b> </h3>
      <?php }
        if(isset($_GET["search"]))
        {
          $search = $_GET["search"];
          $sql = "select  product_id, name, price\n"
                . "from product \n"
                . "where name like \"%".$search."%\"";
          $result = $conn->query($sql); ?>
          <h3 style="margin:10px;"> <b> <?php echo "Showing results of \"".$search."\""; ?> <b> </h3>
      <?php }  ?>
      <div class="row ">

        <?php while ( $row = $result->fetch_assoc() ){ ?>
          <div class="col-sm-6">
            <br>
            <div class="card text-center">
              <?php
                $sqlq = "select image from `product` where product_id='".$row['product_id']."'";
                $rows = $conn->query($sqlq);
                if(!$rows)
                  echo "error";
                $im = mysqli_fetch_array($rows);
                $img_src = "data:image/jpeg;base64,".base64_encode( $im['image'] );
              ?>

              <img src=<?php echo $img_src ?> class="card-img-top img_css mx-auto" alt=<?php echo $row['product_id'] ?>>
              <div class="card-body">
                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                <p class="card-text">Price ( Rupees ) : <?php echo $row['price'] ?></p>
                <?php $link = "product_template.php?product_id=".$row['product_id'] ?>
                <a href=<?php echo $link ?> class="btn btn-success">BUY NOW</a>
              </div>
            </div>
            <br>
          </div>
        <?php } ?>

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
