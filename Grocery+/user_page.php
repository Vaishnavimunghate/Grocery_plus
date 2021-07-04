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
    if(isset($_POST['sub']) ){
      $curr = $_POST['curr_pass'];
      $pass = $_POST['new_pass'];
      $len = strlen($pass);
      if($len < 8){
        echo '<div class="container-fluid"><h4 style="background-color:Red;"> Minimum length is 8!</h4></div>';
      }
      else
      {
        if($_POST['new_pass'] != $_POST['cnf_pass']){
           echo '<div class="container-fluid"><h4 style="background-color:Red;"> Your passwords did not match!</h4></div>';
        }
        else{
          $query = "SELECT password from user as u where u.email_id = '$username' and u.password='$curr'"; 
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
            $sql = "UPDATE user set password= '$pass' where user.password='$curr' and user_man.email_id='$username' ";
            mysqli_query($conn,$sql);
            echo '<div class="container-fluid"><h4 style="background-color:Green;"> Your password is successfully updated!</h4></div>';
          }
          else{
            echo '<div class="container-fluid"><h4 style="background-color:Red;"> Current password did not match!</h4></div>';
          } 
        }
      }               
    }
    if(isset($_POST['submit']) ){
      $user = $_POST['user_name'];
      $phone = $_POST['num'];
      $loc = $_POST['loc'];
      $city = $_POST['city'];
      $state = $_POST['state'];
      $pin = $_POST['pin'];
      $len2 = strlen($pin);
      if($len2 == 6){
        if(empty($phone)){
          $sql = "UPDATE user set name= '$user', phone_number=NULL, location='$loc', city='$city', state='$state', pincode='$pin' where user.email_id= '$username' ";
          mysqli_query($conn,$sql);
          echo '<div class="container-fluid"><h4 style="background-color:Green;"> Your info is updated successfully!</h4></div>';
        }
        else{
          $len1 = strlen($phone);
          if($len1 == 10){
            $sql = "UPDATE user set name= '$user', phone_number='$phone', location='$loc', city='$city', state='$state', pincode='$pin' where user.email_id= '$username' ";
            mysqli_query($conn,$sql);
            echo '<div class="container-fluid"><h4 style="background-color:Green;"> Your info is updated successfully!</h4></div>';
          }
          else{
            echo '<div class="container-fluid"><h4 style="background-color:Red;"> Phone number should be of 10 digits!</h4></div>';
          }
        }
      }
      else{
        echo '<div class="container-fluid"><h4 style="background-color:Red;"> Pincode should be of 6 digits!</h4></div>';
      }
    }

    ?>
  <div class="container-fluid">
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
      <a class="navbar-brand" href="main-page.html">
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
      <div class="content-section">
        <legend class="border-bottom mb-4"><h3 class="account-heading">User Info </h3></legend>
        <?php
          $sql = "SELECT * from user as u where u.email_id = '$username' ";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
             
        ?>
        <h4 class="dispaly-4">Name: </h4>
        <h4 class="dispaly-4">
          <?php echo $row["name"]; ?>
        </h4><br>
        <h4 class="dispaly-4">Email: </h4>
        <h4 class="dispaly-4">
          <?php echo $row["email_id"]; ?>
        </h4><br>
        <h4 class="dispaly-4">Phone number: </h4>
        <h4 class="dispaly-4" id="phone">
          <?php
              if($row["phone_number"]==NULL){
               echo "No phone number is added"; 
              }
              else{
                echo $row["phone_number"];
              } 
           ?>
        </h4><br>
        <h4 class="dispaly-4">Address:</h4>
        <h4 class="dispaly-4">
          <?php
            echo $row["location"]. ", " . $row["city"]. ", ".$row["state"]. ", ".$row["pincode"] ; 
          ?>   
         </h4><br>
         <?php
            }
          }  
          ?>
      </div>
      <div class="content-section">

        <legend class="border-bottom mb-4"><h3 class="account-heading">Edit Info</h3></legend>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <h4 class="dispaly-4" >Name:</h4>
          <input type="text" name="user_name" placeholder="Enter Name" required><br><br>
          <h4 class="dispaly-4" >Phone Number:</h4>
          <input type="text" name="num" placeholder="Enter phone number(optional)"><br><br>
          <h4 class="dispaly-4" >Location:</h4>
          <input type="text" name="loc" placeholder="Enter Location" required><br><br>
          <h4 class="dispaly-4" >City:</h4>
          <input type="text" name="city" placeholder="Enter City" required><br><br>
          <h4 class="dispaly-4" >State:</h4>
          <input type="text" name="state" placeholder="Enter State" required><br><br>
          <h4 class="dispaly-4" >Pincode:</h4>
          <input type="text" name="pin" placeholder="Enter Pincode" required><br><br>
          <button class="button" name="submit">Save Changes</button>
        </form>
      </div>
      <div class="content-section">
        <legend class="border-bottom mb-4"><h3 class="account-heading">Change Password</h3></legend>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
          <h4 class="dispaly-4" >Current Password:</h4><br>
          <input type="password" name="curr_pass" placeholder="Enter current password" required><br>
          <h4 class="dispaly-4" >New Password:</h4><br>
          <input type="password" name="new_pass" placeholder="Enter new password" required /><br>
          <h4 class="dispaly-4" >Confirm Password:</h4><br>
          <input type="password" name="cnf_pass" placeholder="Re-enter new password" required  /><br>
          <button class="button" name = "sub" >Change Password</button>
        </form>
      </div>
    </div>

    <?php
    CloseCon($conn);
        ?>
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
