<?php
// Load database class
require_once('src/Helper/Database.php');

use Helper\Database;
// Setup the database with adminer
$objConn = new Database('localhost', 'aeracing_fabioh', '%8i}nZ)v2j.Yk>75', 'aeracing_fabioh');

// Create connection
$conn = $objConn->connect();

// Handle inserts
if (isset($_POST) && !empty($_POST['lastname']) && !empty($_POST['firstname'])) {
    $sqlInsert = sprintf(
        "INSERT INTO tl_test (lastname,firstname) VALUES ('%s','%s')",
        $_POST['lastname'],
        $_POST['firstname']
    );
    if ($conn->query($sqlInsert) === true) {
        $message = sprintf(
            "Successfully added new record: <br>firstname %s,<br>lastname %s.",
            $_POST['lastname'],
            $_POST['firstname']
        );
    } else {
        $message = "Error: ".$sqlInsert."<br>".$conn->error;
    }
}

// Select all records
$sqlSelect = "SELECT * FROM tl_test ORDER BY lastname";
$data = mysqli_query($conn, $sqlSelect);

// Close connection
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<title>mysql database playground!</title>
</head>
<body>
<div id="wrapper">
	<div class="container">
		<h1>Enter your data here!</h1>
      <?php if (isset($message)): ?>
				<div class="alert alert-primary" role="alert">
            <?= $message ?>
				</div>
      <?php endif; ?>
		<form action="index.php" method="post">
			<div class="form-group">
				<label for="inputFirstname">Firstname</label>
				<input type="text" class="form-control" id="inputFirstname" name="firstname" aria-describedby="inputFirstnameHelp">
				<small id="inputFirstnameHelp" class="form-text text-muted">Enter your firstname, please.</small>
			</div>
			<div class="form-group">
				<label for="inputLastname">Lastname</label>
				<input type="text" class="form-control" id="inputLastname" name="lastname" aria-describedby="inputLastnameHelp">
				<small id="inputLastnameHelp" class="form-text text-muted">Enter your lastname, please.</small>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>

		<!-- List data records -->
		<table class="table mt-5">
        <?php while ($row = mysqli_fetch_array($data)): ?>
					<tr>
						<td><?= $row['id'] ?></td>
						<td><?= $row['lastname'] ?></td>
						<td><?= $row['firstname'] ?></td>
					</tr>
        <?php endwhile; ?>
		</table>
	</div>
</div>


<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


</body>
</html>