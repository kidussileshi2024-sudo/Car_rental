<?php
require "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$b_id = $_POST['b_id'];
$car_id = $_POST['car_id'];
$fine = $_POST['fine'];
$employee_id = $_POST['employee_id'];

mysqli_begin_transaction($conn);

/* get booking start date */
$res = mysqli_query($conn,"SELECT Start_date,Cu_id FROM Booking WHERE B_id=$b_id");
$row = mysqli_fetch_assoc($res);

$start_date = $row['Start_date'];
$customer_id = $row['Cu_id'];
$today = date("Y-m-d");

/* days calculation */
$days = (strtotime($today) - strtotime($start_date)) / (60 * 60 * 24);
if($days < 1) $days = 1;

/* get car pricing */
$sql= "SELECT Cars.Price_adjs, Models.Price_per_day
FROM Cars
JOIN Models ON Cars.Model_id = Models.M_id
WHERE Cars.C_id = $car_id";

$result = mysqli_query($conn, $sql);
$car = mysqli_fetch_assoc($result);

/* total price */
$daily_price = $car['Price_per_day'] * (1 - $car['Price_adjs']);
$price = $daily_price * $days;
mysqli_query($conn,"UPDATE booking SET End_date='$today'");

/* ===== NO FINE FLOW ===== */
if($fine == 0){

    /* release car */
    mysqli_query($conn,"UPDATE cars SET IS_available=1 WHERE C_id=$car_id");

    /* close booking AFTER payment */
    mysqli_commit($conn);
    ?>

    <html>
    <body>
    <form method="post" action="../Payment/rent_payment.php">
        <input type="hidden" name="b_id" value="<?= $b_id ?>">
        <input type="hidden" name="Type" value="Booking">
        <input type="hidden" name="cu_id" value="<?= $customer_id ?>">
        <input type="hidden" name="car_id" value="<?= $car_id ?>">
        <input type="hidden" name="amount" value="<?= $price ?>">
        <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
        <input type="hidden" name="days" value="<?= $days ?>">
        <input type="hidden" name="price" value="<?= $daily_price?>">
        <input type="submit" value="Proceed to Booking Payment">
    </form>
    </body>
    </html>

    <?php
    exit;

}else{
/* ===== FINE FLOW ===== */

    /* send to maintenance */
    mysqli_query($conn,"INSERT INTO maintenance (Car_id, Start_date, Description)
        VALUES ($car_id, CURDATE(), 'Damage from inspection')
    ");

    mysqli_commit($conn);
    ?>

    <html>
    <body>
    <form method="post" action="../Payment/rent_payment.php">
        <input type="hidden" name="b_id" value="<?= $b_id ?>">
        <input type="hidden" name="Type" value="Booking">
        <input type="hidden" name="fine" value="<?= $fine ?>">
        <input type="hidden" name="cu_id" value="<?= $customer_id ?>">
        <input type="hidden" name="car_id" value="<?= $car_id ?>">
        <input type="hidden" name="amount" value="<?= $price ?>">
        <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
        <input type="hidden" name="days" value="<?= $days ?>">
        <input type="hidden" name="price" value="<?= $daily_price?>">
        <input type="submit" value="Proceed to Booking Payment">
    </form>
    </body>
    </html>

    <?php
}
?>