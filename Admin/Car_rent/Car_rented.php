<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../db.php";
$car_id = $_POST['car_id'];
$employee_id = $_POST['employee_id'];
$cu_id = $_POST['cu_id'];


$sql1 = "
INSERT INTO booking(Cu_id, Car_id, Emp_id, Start_date, End_date)
VALUES ($cu_id, $car_id, $employee_id, CURDATE(), NULL )
";
mysqli_query($conn, $sql1);

$booking_id = mysqli_insert_id($conn);


$sql2 = "UPDATE cars SET IS_available = 0 WHERE C_id = $car_id";
if (!mysqli_query($conn, $sql2)) {
    mysqli_rollback($conn);
    die(mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Booking Completed</h2>

<p>Booking ID: <?= $booking_id ?></p>
<p>booking recorded.</p>

<a href="../admin_home.php">Back to Admin Panel</a>
</body>
</html>
