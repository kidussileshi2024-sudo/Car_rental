<?php
require "../db.php";

$phone = $_POST['phone'];
$employee_id = $_POST['employee_id'];

$sql = "
SELECT b.B_id, b.Car_id, c.Plate_no
FROM booking b
JOIN cars c ON b.Car_id = c.C_id
JOIN customers cu ON b.Cu_id = cu.C_id
WHERE cu.phone_no = '$phone'
  AND c.IS_available = 0 AND b.End_date IS NULL;
";

$res = mysqli_query($conn,$sql);

if(!$res){
    die("SQL Error: " . mysqli_error($conn));
}

if(mysqli_num_rows($res)==0){
    die("No active rental found.");
}
?>

<!DOCTYPE html>
<html>
<body>

<h3>Select Active Rental</h3>

<form method="post" action="wait_for_inspection.php">

<input type="hidden" name="employee_id" value="<?= $employee_id ?>">

<?php while($row = mysqli_fetch_assoc($res)): ?>

    <hr>
    <input type="radio" name="selected_booking" 
           value="<?= $row['B_id'] ?>|<?= $row['Car_id'] ?>" required>

    Booking ID: <?= $row['B_id'] ?> |
    Car ID: <?= $row['Car_id'] ?> |
    Plate: <?= $row['Plate_no'] ?><br>

<?php endwhile; ?>

<br>
<input type="submit" value="Proceed to Inspection Check">


</form>


</body>
</html>