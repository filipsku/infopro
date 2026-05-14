<?php
session_start();
?>

<?php
	$server="localhost";
	$user="root";
	$pass="";
	$db="db";
	$userid="0";
    $username="";
	$conn=mysqli_connect($server,$user,$pass,$db);
	if(!$conn){
		die("konnekcija pala ".msqi_connect_error());		
	}
	echo "konekcija uspešna <br>";
    $sql= "select username from account where id = $userid";
    if($userid!=0){
        $username=$conn->query($sql);
    }else{
        $username="Default User";
    }
    echo "<a href="login.php">$username</a>"

	$sql="select * from message";
	$rez=$conn->query($sql);
	if($rez->num_rows>0){
		while($row=$rez->fetch_assoc()){
			if($userid = $row["Receiver"]){
				echo "<br>".$row["Sender"]." . ".$row["Content"];
			}
		}
	}
?>