<?php require "db.php";

/* get categories */
$cats = mysqli_query($conn, "SELECT * FROM Category ORDER BY Name");
?>

<!DOCTYPE html>
<html>
<body>

<h2>Rent a Car</h2>

<form method="post" action="rent_select_car.php">

Employee ID :  
<input type="number" name="employee_id" required><br><br>

<h3>Select categories</h3>

<?php while($c = mysqli_fetch_assoc($cats)): ?>
    <input type="checkbox" name="cat[]" value="<?= $c['C_id'] ?>">
    <?= $c['Name'] ?><br>
<?php endwhile; ?>

<br>
<input type="submit" name="filter" value="Show available cars">

</form>

</body>
</html>