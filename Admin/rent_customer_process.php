<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";

$car_id = $_POST['car_id'];
$employee_id = $_POST['employee_id'];
$phone = $_POST['phone_no'];

/* check customer */
$res = mysqli_query(
    $conn,
    "SELECT * FROM Customers WHERE Phone_no='$phone'"
);

if (!$res) {
    die(mysqli_error($conn));
}

if (mysqli_num_rows($res) == 1) {
    /* customer exists */
    $cust = mysqli_fetch_assoc($res);
    $customer_id = $cust['C_id'];
    $customer_name = $cust['Name'];

    ?>
    <!DOCTYPE html>
    <html>  
        <h2>Customer Found</h2>
        <p>Customer Name: <?= $customer_name ?></p>
        </html> 
    <form method="post" action="Car_rented.php">
        <input type="hidden" name="car_id" value="<?= $car_id ?>">
        <input type="hidden" name="cu_id" value="<?= $customer_id ?>">
        <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
        
        <input type="submit" value="confirm Booking">
    </form>
    <?php
    exit;

} else {
    /* customer not exists → show form */
    ?>
    <!DOCTYPE html>
    <html>

    <body>

        <h2>New Customer</h2>

        <form method="post" action="rent_create_customer.php">
            <input type="hidden" name="car_id" value="<?= $car_id ?>">
            <input type="hidden" name="employee_id" value="<?= $employee_id ?>">

            Name: <input name="name" required><br>
            Address: <input name="address" required><br>
            License: <input name="driving_license_num" required><br>
            Age: <input type="number" name="age"><br>
            Phone: <input name="phone_no" value="<?= $phone ?>" required><br><br>

            <input type="submit" value="Create Customer">
        </form>

    </body>

    </html>
    <?php
}
?>