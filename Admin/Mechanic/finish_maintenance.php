<?php
require "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ment_id = $_POST['ment_id'];
$car_id = $_POST['car_id'];
$employee_id = $_POST['employee_id'];
$description = $_POST['description'] ?? '';
$price_adj = $_POST['price_adj'] ?? null;
$mech_ids = $_POST['mech_ids'] ?? [];

mysqli_begin_transaction($conn);


foreach($mech_ids as $mid){
    mysqli_query($conn,"
        INSERT INTO Employee_Maintenance(Emp_Id, Ment_id)
        VALUES ($mid, $ment_id)
    ");
}


mysqli_query($conn,"
UPDATE maintenance
SET End_date = CURDATE(), Description = '$description'
WHERE M_id = $ment_id
");

mysqli_query($conn,"
UPDATE cars SET IS_available = 1 WHERE C_id = $car_id
");

if($price_adj !== null && $price_adj !== ""){
    mysqli_query($conn,"
    UPDATE cars SET Price_adjs = $price_adj WHERE C_id = $car_id
    ");
}

mysqli_commit($conn);
?>

<!DOCTYPE html>
<html>
<body>

<h2>Maintenance Completed</h2>

<p>Car is now available for rent.</p>

<form method="post" action="mechanic_maintenance.php">
    <input type="submit" value="Back to Maintenance List">
</form>

</body>
</html>