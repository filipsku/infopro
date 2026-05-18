<?php
	$server="localhost";
	$user="root";
	$pass="";
	$db="db";
    $username=$_SESSION['username'];
	$conn=mysqli_connect($server,$user,$pass,$db);

	// Get user ID
	$sql =	"select id from account where username='$username'";
	$rez = $conn->query($sql);
	$rez = $rez->fetch_assoc();
	$userid = $rez["id"];

	echo "<h2>Welcome, ".$username."!</h2><br>";
	echo "<a href="write.php">Write a message to another user</a><br>";
	echo "<h3>Your messages:</h3>";
	// Get messages for the user
	$sql = "select * from message where receiver='$userid'";
	$rez = $conn->query($sql);
	if($rez->num_rows>0){
		while($row=$rez->fetch_assoc()){
			if($userid = $row["Receiver"]){
				echo "<br>".$row["Sender"]." . ".$row["Content"];
			}
		}
	}
?>