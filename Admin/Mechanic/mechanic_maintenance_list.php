<?php
require "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$employee_id = $_POST['employee_id'];

$sql = "
SELECT Emp_id, B_id
FROM employees
WHERE Emp_id = ? AND Role = 'Mechanic'
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $employee_id); 
mysqli_stmt_execute($stmt);
$emp_res = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($emp_res) == 0){
    die("Invalid mechanic ID.");
}

$emp = mysqli_fetch_assoc($emp_res);
$branch_id = $emp['B_id'];



$sql = "
SELECT m.M_id, m.Car_id, c.Plate_no, m.Start_date, m.Description
FROM maintenance m
JOIN cars c ON m.Car_id = c.C_id
WHERE m.End_date IS NULL
AND c.Branch_id = $branch_id
";

$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Maintenance Jobs</title>
</head>
<body>

<h2>Maintenance Jobs - Branch <?= $branch_id ?></h2>

<form method="post" action="maintenance_work.php">

<input type="hidden" name="employee_id" value="<?= $employee_id ?>">

<?php if(mysqli_num_rows($res)==0): ?>
    <p>No active maintenance jobs in your branch.</p>
<?php else: ?>

<?php while($row = mysqli_fetch_assoc($res)): ?>

    <hr>
    <input type="radio" name="ment_id" value="<?= $row['M_id'] ?>" required>
    Maintenance ID: <?= $row['M_id'] ?><br>
    Car Plate: <?= $row['Plate_no'] ?><br>
    Started: <?= $row['Start_date'] ?><br>
    Description: <?= $row['Description'] ?><br>

<?php endwhile; ?>

<br>
<input type="submit" value="Open Maintenance Job">

<?php endif; ?>

</form>

</body>
</html>