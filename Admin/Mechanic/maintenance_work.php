<?php
require "../db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ment_id = $_POST['ment_id'];
$employee_id = $_POST['employee_id'];


$sql = "
SELECT m.M_id, m.Car_id, c.Branch_id, c.Price_adjs
FROM maintenance m
JOIN cars c ON m.Car_id = c.C_id
WHERE m.M_id = $ment_id
";
$res = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);

$car_id = $data['Car_id'];
$branch_id = $data['Branch_id'];
$current_adj = $data['Price_adjs'];


$check = mysqli_query($conn,"
SELECT * FROM Employee_Maintenance WHERE Ment_id = $ment_id
");

$has_team = mysqli_num_rows($check) > 0;


$mech_res = mysqli_query($conn,"
SELECT Emp_id, Name
FROM employees
WHERE Role='Mechanic' AND B_id = $branch_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../style.css">
    <title>Maintenance Work</title>
</head>
<body>

<h2>Maintenance Work</h2>

<form method="post" action="finish_maintenance.php">

<input type="hidden" name="ment_id" value="<?= $ment_id ?>">
<input type="hidden" name="car_id" value="<?= $car_id ?>">
<input type="hidden" name="employee_id" value="<?= $employee_id ?>">

<?php if(!$has_team): ?>

<h3>Select Mechanics Involved</h3>
<?php while($m = mysqli_fetch_assoc($mech_res)): ?>
    <input type="checkbox" name="mech_ids[]" value="<?= $m['Emp_id'] ?>">
    <?= $m['Name'] ?> (ID: <?= $m['Emp_id'] ?>)<br>
<?php endwhile; ?>

<?php else: ?>
<p>Mechanics already assigned.</p>
<?php endif; ?>

<br>

Description update:<br>
<textarea name="description"></textarea><br><br>

New Price Adjustment (current: <?= $current_adj ?>):  
<input type="number" step="0.01" name="price_adj"><br><br>

<input type="submit" value="Finish Maintenance">

</form>

</body>
</html>