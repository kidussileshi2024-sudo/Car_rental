<?php
require "db.php";

$employee_id = $_POST['employee_id'];
$cats = $_POST['cat'] ?? [];

$branch_filter = "";

/* If employee_id entered → filter by branch */
if (!empty($employee_id)) {
    $res = mysqli_query($conn,
        "SELECT B_id FROM Employees WHERE Emp_id=$employee_id"
    );
    $emp = mysqli_fetch_assoc($res);

    if ($emp) {
        $branch_id = $emp['B_id'];
        $branch_filter = " AND Cars.Branch_id = $branch_id ";
    }
}

/* category filter */
$cat_filter = "";
if (!empty($cats)) {
    $ids = implode(",", $cats);
    $cat_filter = " AND Models.Cat_id IN ($ids) ";
}

$sql = "
SELECT Cars.C_id, Cars.color, Cars.Price_adjs,
       Models.Brand, Models.Name, Models.Fule_type, Models.Price_per_day
FROM Cars
JOIN Models ON Cars.Model_id = Models.M_id
WHERE Cars.IS_available = 1 
$branch_filter
$cat_filter
";

$res = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<body>

<h2>Available Cars</h2>

<?php while($car = mysqli_fetch_assoc($res)): 
    $price = $car['Price_per_day'] * (1 - $car['Price_adjs']);
?>
<hr>
<?= $car['Brand']." ".$car['Name'] ?> (<?= $car['Fule_type'] ?>)<br>
Color: <?= $car['color'] ?><br>
Price/day: €<?= number_format($price,2) ?><br>

<form method="post" action="rent_customer.php">
    <input type="hidden" name="car_id" value="<?= $car['C_id'] ?>">
    <input type="hidden" name="employee_id" value="<?= $employee_id ?>">
    <input type="submit" value="Select this car">
</form>

<?php endwhile; ?>

</body>
</html>