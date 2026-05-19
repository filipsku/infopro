<?php
session_start();
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Process form when data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs to prevent basic XSS
    $sender = $_SESSION['username'];
    $receiver = trim($_POST['receiver']);
    $message = trim($_POST['message_text']);
    $sql = conn->query("select aid from account where username=$sender")
    $sql = $sql->fetch_assoc();
    $senderid = $sql["aid"];
    // Validate if fields are empty
    if (empty(receiver) || empty($message)) {
        $status_message = "<p style='color: red;'>All fields are required.</p>";
    } else {
        $receiverid = $conn->query("select aid from account where username=$receiver")
        $receiverid = $receiverid->fetch_assoc();
        $receiverid = $receiverid["aid"];
        // Prepare an INSERT statement (prevents SQL Injection)
        $stmt = $conn->prepare("INSERT INTO messages (sender, sendername, receiver, receivername, message_text) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $senderid, $sender, $receiverid, $receiver,$message);

        if ($stmt->execute()) {
            $status_message = "<p style='color: green;'>Message sent successfully!</p>";
        } else {
            $status_message = "<p style='color: red;'>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
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
        button:hover { background-color: #4a54e1; }
    </style>
</head>
<body>

<div class="container">
    <h2>Compose New Message</h2>
    
    <!-- Display success or error messages -->
    <?php echo $status_message; ?>

    <form method="POST" action="">

        <div class="form-group">
            <label for="receiver">Receiver Username:</label>
            <input type="text" id="receiver" name="receiver" required>
        </div>

        <div class="form-group">
            <label for="message_text">Message:</label>
            <textarea id="message_text" name="message_text" required></textarea>
        </div>

        <button type="submit">Send Message</button>
    </form>
</div>

</body>
</html>
