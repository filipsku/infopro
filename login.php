<?php
session_start();
?>

<?php
    // Start the connection
    $server="localhost";
	$user="root";
	$pass="";
	$db="db";
    $conn=mysqli_connect($server,$user,$pass,$db);
?>

<?php
    // Form Handling
    if($_SERVER["REQUEST_METHOD"] != "POST") {

        // Login handle
        if($_POST['form_id'='login']{
            // Find the user
            $querry = $conn->query('SELECT password from account where username = $_POST['username']');
            // get the result user password
            if($querry->num_rows > 0) {
                $userpass = $querry->fetch_assoc();
                if($userpass['password'] == $_POST['password']) {
                    // if the password is correct, log the user in
                    $_SESSION['username'] = $_POST['username'];
                    header("Location: mainpage.php");
                } else {
                    // if the password is incorrect, show an error message
                    echo "Incorrect password";
                }
            } else {
                $userpass = false;
                echo "No such username exists";
            }
            $querry->close();
        }

        // Register handle
        elseif($_POST['form_id'='register']{
            // Check if the username already exists
            $querry = $conn->query('SELECT username from account where username = $_POST['username']');
            if($querry->num_rows > 0) {
                echo "Username already exists";
            } else {
                // If the username does not exist, create a new account
                // Trim user inputs to prevent injection
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                $email = trim($_POST['email']);

                // Creates new SQL account entry
                $querry = $conn->query('INSERT INTO account (username, password, email) VALUES (?, ?, ?)');
                $querry->bind_param("sss", $username, $password, $email);
                if($querry) {
                    echo "<a href="mainpage.php">Account created successfully</a>";
                } else {
                    echo "Error creating account: " . $conn->error;
                }
            }
            querry->close();
        }
    }
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>

<h3>Register</h3>
<form action="" method="post">

 <input type="hidden" name="form_id" value="register">

  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>
	  <br>
    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
    <br>
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>
    <br>
    <button type="submit">Register</button>
  </div>
</form>
<br>
<h3>Login</h3>
<form action="" method="post">

  <input type="hidden" name="form_id" value="login">

  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>
	<br>
    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
	<br>
    <button type="submit">Login</button>
  </div>
</form>
</html>