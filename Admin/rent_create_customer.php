<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";

$name = $_POST['name'];
$address = $_POST['address'];
$license = $_POST['driving_license_num'];
$age = $_POST['age'];
$phone = $_POST['phone_no'];
$car_id = $_POST['car_id'];
$employee_id = $_POST['employee_id'];

$sql = "
INSERT INTO customers
(name, address, License_num , Age, Phone_no)
VALUES
('$name','$address','$license',$age,'$phone')
";

if (!mysqli_query($conn, $sql)) {
    die(mysqli_error($conn));
}

$customer_id = mysqli_insert_id($conn);

?>
<form method="post" action="Car_rented.php">
    <input type="hidden" name="car_id" value="<?= $car_id ?>">
    <input type="hidden" name="cu_id" value="<?= $customer_id ?>">
    <input type="hidden" name="employee_id" value="<?=$employee_id ?>">
    <input type="submit" value="Finish Rental">
</form>
<?php
exit;
?>