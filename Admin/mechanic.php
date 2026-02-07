<?php
require "db.php";

/* get variables from included file */
include "wait_for_inspection.php";
/*
Available variables from include:
$b_id
$car_id
$employee_id   // receptionist
*/

/* get receptionist branch */
$branch_q = mysqli_query($conn,"
    SELECT B_id 
    FROM employees 
    WHERE Emp_id = $employee_id
");

if(!$branch_q) die(mysqli_error($conn));

$branch_row = mysqli_fetch_assoc($branch_q);
$branch_id = $branch_row['B_id'];

/* get mechanics from same branch */
$mech_q = mysqli_query($conn,"
    SELECT Emp_id, Name
    FROM employees
    WHERE B_id = $branch_id
      AND Role = 'mecha'
");

if(!$mech_q) die(mysqli_error($conn));

/* enforce one inspection per booking */
$check_ins = mysqli_query($conn,"
    SELECT 1 FROM inspection WHERE Book_id = $b_id
");

if(mysqli_num_rows($check_ins) > 0){
    die("Inspection already exists for this booking.");
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Mechanic Inspection</h2>

<form method="post" action="save_inspection.php">

<!-- mechanic dropdown -->
Mechanic:
<select name="em_id" required>
    <option value="">-- Select Mechanic --</option>
    <?php while($m = mysqli_fetch_assoc($mech_q)): ?>
        <option value="<?= $m['Emp_id'] ?>">
            <?= $m['Name'] ?> (ID: <?= $m['Emp_id'] ?>)
        </option>
    <?php endwhile; ?>
</select>
<br><br>

<!-- readonly booking and car -->
Booking ID:
<input type="number" name="book_id" value="<?= $b_id ?>" readonly><br><br>

Car ID:
<input type="number" name="car_id" value="<?= $car_id ?>" readonly><br><br>

Damage description:<br>
<textarea name="damage"></textarea><br><br>

Fine amount (0 if none):
<input type="number" name="fine" step="0.01" value="0"><br><br>

<input type="submit" value="Save Inspection">

</form>

</body>
</html>