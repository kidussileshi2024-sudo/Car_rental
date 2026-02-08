<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../db.php"; 

$sql = "SELECT I_id,Em_id, Book_id, Car_id FROM Inspection WHERE Inspection_done=0 LIMIT 1";
$result = mysqli_query($conn, $sql);
if ($result) {
     $row = mysqli_fetch_assoc($result);
    $employee_id= $row["Em_id"];
    $b_id = $row["Book_id"];
    $car_id = $row["Car_id"];
    $i_id = $row["I_id"];
        #echo "Employee ID: " . $row['Em_id'] . ", Booking ID: " . $row['Book_id'] . ", Car ID: " . $row['Car_id'] . "<br>";
    
} else {
    echo "Error: " . mysqli_error($conn);
}

#echo"$i_id,$employee_id, $b_id, $car_id";
$sql1 = " SELECT B_id FROM Employees 
WHERE Emp_id = $employee_id";
$branch_q = mysqli_query($conn,$sql1);

if(!$branch_q)
     die(mysqli_error($conn));

$branch_row = mysqli_fetch_assoc($branch_q);
$branch_id = $branch_row['B_id'];


$mech_q = mysqli_query($conn,"
    SELECT Emp_id, Name
    FROM Employees
    WHERE B_id = $branch_id
      AND Role = 'Mechanic'
");

if(!$mech_q) die(mysqli_error($conn));
?>
<!DOCTYPE html>
<html>
<body>

<h2>Mechanic Inspection</h2>

<form method="post" action="save_inspection.php">

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


Booking ID:  
<input type="number" name="book_id" value="<?= $b_id ?>" readonly><br><br>

Car ID:  
<input type="number" name="car_id" value="<?= $car_id ?>" readonly><br><br>

Damage description:<br>
<textarea name="damage"></textarea><br><br>

Fine amount (0 or null if none):  
<input type="number" name="fine" step="0.01"><br><br>
<input type="hidden" name="i_id" value="<?= $i_id ?>">

<input type="submit" value="Save Inspection">

</form>
</body>
</html>