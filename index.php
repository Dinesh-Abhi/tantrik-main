<?php
// Load the CSV data
$csvFile = 'map.csv';
$students = [];
$error="";
// Read the CSV file and store data in an associative array
if (($handle = fopen($csvFile, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
        $students[$data[0]] = $data[1];
    }
    fclose($handle);
}
$error="";
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $error="";
    // Validate the username
    if (array_key_exists($username, $students)) {
        $redirectUrl = $students[$username];
        // Redirect to JupyterHub with the username pre-filled
        $username = strtolower($username);
        $loginUrl = 'http://'.$redirectUrl.':8000/hub/login?username=' . urlencode($username);
        header("Location: $loginUrl");
        exit;
    } else {
        $error = "You are not assigned to any Tantrik instance. Please reach out to the administrator for assistance.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect To Tantrik Instance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333; /* Adjust text color for readability */
        }
        .container {
            position: absolute;
            right: 5%; /* Adjusted margin from the right side */
            top:21%;
            background-color: #fff;
            padding: 80px 40px; /* Increased padding for a larger box */
            border-radius: 15px; /* More rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); /* More prominent shadow */
            max-width: 400px; /* Increased width */
            width: 100%;
            box-sizing: border-box;
        }
        .container img {
          width: 240px;
          display: block;
          margin: 0 auto 35px auto;
        }
        .container input {
            margin: 15px 0; /* Increased margin for better spacing */
            padding: 15px; /* Increased padding for input fields */
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        .container button {
            padding: 15px 20px; /* Increased padding for button */
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #1c91be;
            color: #fff;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .container button:hover {
            background-color: #19576f;

        }
        .error {
            color: #dc3545;
            margin-top: 25px;
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            font-family: initial;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.querySelector('input[name="username"]');
            usernameInput.addEventListener('input', function() {
                this.value = this.value.toLowerCase();
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Tantrik Logo">
        <form method="POST">
            <input type="text" name="username" placeholder="Enter username" required>
            <button type="submit">Connect to My Tantrik Instance</button>
        </form>
        <a href="http://10.11.51.225/tantrik_student_manual.pdf" target="_blank" style="text-align: center;/*! text-decoration: none; *//*! padding: ; */margin: auto;color: #1c91be;display: flex;justify-content: center;align-items: center;padding-top: 20px;font-weight: bold;font-style: ;font-size: 14px;font-family: initial;"> Tantrik Student Manual</a>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

    </div>
</body>
</html>
