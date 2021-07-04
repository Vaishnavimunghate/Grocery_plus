<?php
  include 'db_connection.php';
  $conn = OpenCon();

  $orderid = $_GET['orderid'];
  $sql = "UPDATE user_order set order_status='DELIVERED' where user_order.order_id='$orderid' ";
  mysqli_query($conn,$sql);

  header('location:deli_order.php');

  CloseCon($conn);
?>
