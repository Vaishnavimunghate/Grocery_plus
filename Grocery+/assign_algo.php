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
$orderid=mysqli_real_escape_string($conn, $_POST['orderID']);
$email = mysqli_real_escape_string($conn, $_POST['mail']);
$salary = 100.00;
$sql1="INSERT INTO order_delivery_man (email_id, order_id, order_salary)
    			  VALUES('$email', '$orderid', '$salary')";
if ($conn->query($sql1) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}

$sql = "UPDATE user_order set order_status='DELIVERING' where user_order.order_id='$orderid' ";
mysqli_query($conn,$sql);


$mail->AddAddress("$email");
$mail->SetFrom("group22grocery@gmail.com", "Grocery+");
$mail->AddReplyTo("group22grocery@gmail.com", "Grocery+"); 
$mail->Subject = "New Order ";
$content =" <div> <br><br><p>  A new order has been added! Check your order list. Order id is". $orderid . "</p></div><br>";
          
$mail->MsgHTML($content);
 
 if(!$mail->Send()) {
    echo "Error while sending Email.";
  } 
    else {
    echo "<script>alert('Notification sent to Delivery man through mail');document.location.href=('admin_order.php');</script>";
    exit();
  }

  CloseCon($conn);
?>
