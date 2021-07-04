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
  <title>Document</title>
  <style>
  .login-box {
    background-color: white;
    color: black;
    margin: 30px;
  }
  .heading-box {
    background-color: #4CAF50;
    color: white;
    width : 100%;
    height : 60px;
    padding: 10px;
  }
  .center {
    margin: auto;
    width: 30%;
  }
  .details-box {
    margin : 10px;
    padding : 10px;
    width : auto;
  }
  .text-box {
    margin : 10px;
    padding : 10px;
  }
  .container {
    position: relative;
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px 20px 30px 20px;
  }
  /* Full-width input fields */
  input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }

  /* Set a style for all buttons */
  button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
  }
  </style>
</head>
<body>
  <?php
    session_start();
    if(isset($_POST['submt']) ){
      $name = $_POST['ad_name'];
      $pass = $_POST['ad_pass'];
      $_SESSION['ad_name'] = $name;
      if($pass=="password" && $name=="admin"){
         header('location:admin_order.php');
      }
      else{
        echo '<div class="container-fluid"><h4 style="background-color:Red;"> Values did not match!</h4></div>';
      }              
    } 
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
          <div>
        </div>
      </div>
    </nav>


    <!-- <h1 class = "display-3">Online Grocery Store</h1>
    <h1 class = "dispaly-4"> Under Construction !</h1> -->
    <div class="center">
      <div class="login-box">
        <div class="heading-box">
          <h3 align="center"><b>ADMIN - LOGIN</b> </h3>
        </div>
        <div class="container">
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label><b>Username</b></label>
            <input type="text" name="ad_name" size="20" placeholder="Enter Username" required>
            <label for="uname"><b>Password</b></label>
            <input type="password" name="ad_pass" size="20" placeholder="Enter Password" required>
            <button type="submit" name="submt" >LOGIN</button>
          </form>
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
