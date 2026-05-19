<?php
session_start();
?>

<?php
	$server="localhost";
	$user="root";
	$pass="";
	$db="db";
    $username=$_SESSION['username'];
	$conn=mysqli_connect($server,$user,$pass,$db);

	// Get user ID
	$sql =	"select aid from account where username='$username'";
	$rez = $conn->query($sql);
	$rez = $rez->fetch_assoc();
	$userid = $rez["aid"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compose Message</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; padding: 20px; }
        .container { max-width: 500px; background: #fff; padding: 20px; margin: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 150px; }
        button { background-color: #5c67f2; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
		.button { background-color: #5c67f2; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #4a54e1; }
    </style>
</head>
<body>
	<h2>Welcome <?php echo $username?></h2>
	<a href="write.php" class="button">Write a message to another user</a><br>
	<h3>Your incoming messages:</h3><br>
	<?php   // Get messages for the user
	$sql = "select * from message where receiver='$userid'";
	$rez = $conn->query($sql);
	if($rez->num_rows>0){
		while($row=$rez->fetch_assoc()){
			if($userid = $row["Receiver"]){
				echo "<div class="container">".$row["Sendername"]." : ".$row["Content"]."</div><br>";
			}
		}
	}
	else{
		echo "No messages for you.";
	}
	?>

	<h3>Your outgoing messages:</h3>
	<?php   // Get messages for the user
	$sql = "select * from message where sender='$userid'";
	$rez = $conn->query($sql);
	if($rez->num_rows>0){
		while($row=$rez->fetch_assoc()){
			if($userid = $row["Sender"]){
				echo "<div class="container">".$row["Receivername"]." : ".$row["Content"]."</div><br>";
			}
		}
	}
	else{
		echo "You sent no messages.";
	}
	?>
</body>
