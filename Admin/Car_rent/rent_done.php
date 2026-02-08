<?php
require "../db.php";
$b_id = $_POST['b_id'];
$Type = $_POST['Type'];
?>

<!DOCTYPE html>
<html>
<body>

<h2>Payment Completed</h2>

<p>Booking ID: <?= $b_id ?></p>
<p><?php echo $Type; ?> Payment recorded.</p>

<a href="../admin_home.php">Back to Admin Panel</a>
</body>
</html>
