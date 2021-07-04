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
  <title>Document</title>
  <style>
  .search-container {
    padding: 6px;
    margin-top: 8px;
    float: center;
    height: 100%;
  }
  .search-container input[type=text] {
    padding: 6px;
    margin-top: 8px;
    font-size: 17px;
    border: none;
  }
  .search-container button {
    padding: 6px;
    margin-top: 8px;
    margin-left: 0;
    background: white;
    font-size: 17px;
    border: none;
    cursor: pointer;
  }

  .search-container button:hover {
    background: #ccc;
  }
  .content-box {
    background-color: white;
    color: black;
    margin-top: 20px;
    margin-left: 120px;
    margin-right: 120px;
    margin-bottom: 40px;
  }
  .dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
  }

  .dropbtn:hover, .dropbtn:focus {
    background-color: #2980B9;
  }

  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    width: 100%;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {background-color: #ddd;}

  .dropdown:hover .dropdown-content {display: block;}

  .dropdown:hover .dropbtn {background-color: #3e8e41;}
  .arrow {
    border: solid white;
    border-width: 0 3px 3px 0;
    display: inline-block;
    padding: 3px;
    margin-left: 20px;
    font-size: 18px;
  }
  .down {
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
  }
  .offerbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
  }

  .offerbtn:hover, .offerbtn:focus {
    background-color: #3e8e41;
  }
  .cartbtn {
    border: none;
    background-color: inherit;
    padding: 14px 28px;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;
  }

  .cartbtn:hover {background: #eee;}

  .mySlides {display: none}
  img {vertical-align: middle;}

  /* Slideshow container */
  .slideshow-container {
    position: relative;
    margin: auto;
  }

  /* Next & previous buttons */
  .prev, .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
  }

  /* Position the "next button" to the right */
  .next {
    right: 0;
    border-radius: 3px 0 0 3px;
  }

  /* On hover, add a black background color with a little bit see-through */
  .prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
  }

  /* Caption text */
  .text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
  }

  /* Number text (1/3 etc) */
  .numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
  }

  /* The dots/bullets/indicators */
  .dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
  }

  .active, .dot:hover {
    background-color: #717171;
  }

  .thankyou {
    background: #4CAF50;
    color: white;
    width: 100%;
    padding: 10px;
  }
  </style>
</head>
<body>
  <?php
  include 'db_connection.php';

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

  if (isset($_POST['search_btn'])) {
    $search = mysqli_real_escape_string($db, $_POST['search_bar']);
    $link = "product_search_page.php?search=".$search;
    header("location: ".$link);
  }

  CloseCon($db);
	?>
  <div class="contain">
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


    <div class="search-container" align="center">
      <form method="post" action="main-page.php">
        <input type="text" placeholder="Search Products.." name="search_bar">
        <button type="submit" name="search_btn"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <div class="content-box">
      <div class="dropdown">
        <button class="dropbtn">
          SHOP BY CATEGORY
          <i class="arrow down"></i>
        </button>
        <?php
          $conn = OpenCon();
          $sql = "select distinct(category)\n"
                . "from product_category \n";
          $result = $conn->query($sql);
        ?>
        <div id="category" class="dropdown-content">
          <?php while ( $row = $result->fetch_assoc() ){
            $category = str_replace(" ","_",$row['category']);
            $link = "product_search_page.php?category_id=".$category ?>
          <a href=<?php echo $link ?>><?php echo $row['category'] ?></a>
          <?php } ?>
        </div>
      </div>
      <a href="offer_search_page.php">
        <button class="offerbtn">
          <img src="images/offer.png" width=15 height=15>
          OFFER
        </button>
      </a>
      <a href="cart_page.php">
        <button class="cartbtn float-right">
          <img src="images/cart.png" width=25 height=25>
          My Cart
        </button>
      </a>
      <div class="slideshow-container">

        <div class="mySlides">
          <div class="numbertext">1 / 4</div>
          <img src="images/fikri-rasyid-ezeC8-clZSs-unsplash.jpg" style="width:100%; height:700px">
        </div>

        <div class="mySlides">
          <div class="numbertext">2 / 4</div>
          <img src="images/maddi-bazzocco-Hz4FAtKSLKo-unsplash.jpg" style="width:100%; height:700px">
        </div>

        <div class="mySlides">
          <div class="numbertext">3 / 4</div>
          <img src="images/neonbrand-SvhXD3kPSTY-unsplash.jpg" style="width:100%; height:700px">
        </div>

        <div class="mySlides">
          <div class="numbertext">4 / 4</div>
          <img src="images/nrd-D6Tu_L3chLE-unsplash.jpg" style="width:100%; height:700px">
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>

      <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
      </div>

      <br>
      <h5 align="center">Products with Offers</h5>
      <hr>
      <?php
        $conn = OpenCon();
        $sql = "select  product_id, name, price, offer_name, percentage\n"
                  . "from product natural join offer_product natural join offer\n";
        $result = $conn->query($sql);

      ?>
      <div class="row" align="center">

        <?php while ( $row = $result->fetch_assoc() ){ ?>
          <div class="col-sm-3" style="margin-left:80px">
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
                <p style="color:red"><b>
                  <?php echo $row['offer_name'] ?>
                </b></p>
                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                <p class="card-text">Price ( Rupees ) : <del><?php echo $row['price'] ?></del>  <?php echo (1-$row['percentage']/100)*$row['price'] ?></p>
                <?php $link = "product_template.php?product_id=".$row['product_id'] ?>
                <a href=<?php echo $link ?> class="btn btn-success">BUY NOW</a>
              </div>
            </div>
            <br>
          </div>
        <?php } ?>
        </div>
      <div class="thankyou">
        <h5 align="center"> Thank You for Shopping with Grocery+ ! </h5>
      </div>
      <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
          showSlides(slideIndex += n);
        }

        function currentSlide(n) {
          showSlides(slideIndex = n);
        }

        function showSlides(n) {
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("dot");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
              slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
        }
      </script>
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
