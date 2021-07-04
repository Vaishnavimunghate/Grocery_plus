<?php
include 'db_connection.php';
$conn = OpenCon();
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPDebug  = 0;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "group22grocery@gmail.com";
$mail->Password   = "Grocery22";
$mail->IsHTML(true);

  $orderid = $_GET['orderid'];
  $sql = "UPDATE user_order set order_status='CANCELLED' where user_order.order_id='$orderid' ";
  mysqli_query($conn,$sql);
  $sql3 = "SELECT * FROM order_delivery_man WHERE order_id='$orderid'";
  $result=$conn->query($sql3);
  $row = $result->fetch_assoc();
  $email=$row["email_id"];

  $mail->AddAddress("$email");
$mail->SetFrom("group22grocery@gmail.com", "Grocery+");
$mail->AddReplyTo("group22grocery@gmail.com", "Grocery+"); 
$mail->Subject = "Order Cancelled ";
$content =" <div> <br><br><p>  An order has been Cancelled! Check your order list. Order id is ". $orderid . "</p></div><br>";
          
$mail->MsgHTML($content);
 
  if(!$mail->Send()) {
    echo "Error in cancellation.";
  } 
    else {
    echo "<script>alert('Order Cancellation is successful!');document.location.href=('my_orders.php');</script>";
    exit();
  }
 

  CloseCon($conn);
?>