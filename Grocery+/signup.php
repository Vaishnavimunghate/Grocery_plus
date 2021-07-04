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
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
  }

  /* Add a background color when the inputs get focus */
  input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
  }

  /* Set a style for all buttons */
  .signup {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
  }
  </style>
</head>
<body>
  <?php
	#echo " <br>";
	#$sql = "SELECT * from user";
	#$result = $conn->query($sql);

	#if ($result->num_rows > 0) {
	  // output data of each row
	  #while($row = $result->fetch_assoc()) {
		#echo "id: " . $row["email_id"]. " - city: " . $row["password"]. "<br>";
	  #}
	#} else {
	  #echo "0 results";
	#}

  include 'db_connection.php';

  session_start();
  $errors = array();

	$db = OpenCon();
	#echo "Connected Successfully";

  // REGISTER USER
  if (isset($_POST['signup_btn'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($db, $_POST['uname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['psw']);
    $password_rep = mysqli_real_escape_string($db, $_POST['psw-repeat']);
    $phone_no = mysqli_real_escape_string($db, $_POST['phone-no']);
    $loc = mysqli_real_escape_string($db, $_POST['loc']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $pin = mysqli_real_escape_string($db, $_POST['pin']);

    if($password != $password_rep)
    {
      array_push($errors, "Passwords do not match!");
    }
    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM user WHERE email_id='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['email_id'] === $email) {
        array_push($errors, "Account with this email already exists. Login now!");
      }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
      $insquery = "INSERT INTO user (email_id, password, phone_number, name, location, city, state, pincode)
    			  VALUES('$email', '$password', '$phone_no', '$name', '$loc', '$city', '$state', '$pin')";
    	if($db->query($insquery) == TRUE)
      {
        $_SESSION['username'] = $email;
        $_SESSION['name'] = $name;
      	$_SESSION['success'] = "You are now logged in";
      	header('location: main-page.php');
      }
      else {
        echo "<script>alert('Insert failed')</script>";
      }
    }
    else {
      echo "<script>alert('$errors[0]')</script>";
    }
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
          <div>
        </div>
      </div>
    </nav>


    <!-- <h1 class = "display-3">Online Grocery Store</h1>
    <h1 class = "dispaly-4"> Under Construction !</h1> -->
    <div class="center">
      <div class="login-box">
        <div class="heading-box">
          <h3 align="center"><b>SIGNUP</b> </h3>
        </div>
        <div class="container">
          <form method="post" action="signup.php">
            <label for="uname"><b>Name</b></label>
            <input type="text" name="uname" size="20" placeholder="Enter Name" required>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
            <label for="phone-no"><b>Phone Number</b></label>
            <input type="text" placeholder="Enter Phone Number (optional)" name="phone-no">
            <div name="address">
              <h4> Address </h4>
              <hr>
              <label for="loc"><b>Location</b></label>
              <input type="text" placeholder="Enter Location" name="loc" required>
              <label for="city"><b>City</b></label>
              <input type="text" placeholder="Enter City" name="city" required>
              <label for="state"><b>State</b></label>
              <input type="text" placeholder="Enter State" name="state" required>
              <label for="pin"><b>Pincode</b></label>
              <input type="text" placeholder="Enter Pincode" name="pin" required>
            </div>
            <input class="signup" type="submit" value="SIGNUP" name="signup_btn">
          </form>
          <br>
          <div align="center">
            <span class="delivery">Already have an account? <a href="user_login.php">Login Now!</a></span>
          </div>
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
