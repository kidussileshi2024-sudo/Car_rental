<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";

$car_id = $_POST['car_id'];
$cu_id  = $_POST['cu_id'];
$amount = $_POST['amount'];
$Type = $_POST['Type'];
$Method = $_POST['Method'];
$booking_id_fine = $_POST['b_id'];
$Invoice = $_POST['Invoice']; 
$employee_id = $_POST['employee_id'];
echo "cu_id: $cu_id, car_id: $car_id, amount: $amount, Type: $Type, Method: $Method";

mysqli_begin_transaction($conn);
if ($Type == "Booking") {
/* insert booking */
$employee_id = $_POST['employee_id'];
echo "employee_id: $employee_id";

$sql1 = "
INSERT INTO Booking(Cu_id, Car_id, Emp_id, Start_date, End_date)
VALUES ($cu_id, $car_id, $employee_id, CURDATE(), NULL )
";
mysqli_query($conn, $sql1);

$booking_id = mysqli_insert_id($conn);

/* update car */
$sql2 = "UPDATE Cars SET IS_available = 0 WHERE C_id = $car_id";
if (!mysqli_query($conn, $sql2)) {
    mysqli_rollback($conn);
    die(mysqli_error($conn));
}
echo"booking_id: $booking_id";
/* insert payment */
$sql3 = "
INSERT INTO Payment(B_id, Type, Invoice, Method,Emp_id,Amount)
VALUES ($booking_id, '$Type', '$Invoice', '$Method', $employee_id, $amount)
";
if (!mysqli_query($conn, $sql3)) {
    mysqli_rollback($conn);
    die(mysqli_error($conn));
}

mysqli_commit($conn);

header("Location: rent_done.php?b_id=$booking_id&Type=$Type");
exit;
} elseif ($Type == "Fine") {
    /* insert fine payment */
    $employee_id_fine = $_POST["employee_id_fine"];
    $sql = "
    INSERT INTO Payment(B_id, Type, Invoice, Method,Emp_id,Amount)
VALUES ($booking_id_fine, '$Type', '$Invoice', '$Method', $employee_id_fine, $amount)
";
    if (!mysqli_query($conn, $sql)) {
        mysqli_rollback($conn);
        die(mysqli_error($conn));
    }

    mysqli_commit($conn);
    
    header("Location: rent_done.php?b_id=$booking_id_fine&Type=$Type");
    exit;
}
?>