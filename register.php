<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>

<div class="form-container">
    <form method="post" action="register.php" id="registrationForm">
        <h2>Register</h2>
        <label for="login">Login:</label>
        <input type="text" id="login" name="login">
        <span id="loginError" class="error"></span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span id="passwordError" class="error"></span>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name">
        <span id="nameError" class="error"></span>

        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname">
        <span id="surnameError" class="error"></span>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country">
        <span id="countryError" class="error"></span>

        <label for="city">City:</label>
        <input type="text" id="city" name="city">
        <span id="cityError" class="error"></span>

        <button type="submit" id="submitButton" disabled>Submit</button>
    </form>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
</div>

</body>
</html>

<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to MySQL database
    $conn = new mysqli("localhost", "root", "", "HW0206DB");
    if ($conn->connect_error) {
        echo "Connection error: " . $conn->connect_error;
        die();
    }

    // Sanitize and validate input data
    $login = sanitize_input($conn, $_POST['login']);
    $password = sanitize_input($conn, $_POST['password']);
    $name = sanitize_input($conn, $_POST['name']);
    $surname = sanitize_input($conn, $_POST['surname']);
    $country = sanitize_input($conn, $_POST['country']);
    $city = sanitize_input($conn, $_POST['city']);

    // Check if user with the same login exists
    $checkExistingQuery = "SELECT * FROM users WHERE login = ?";
    $stmt = $conn->prepare($checkExistingQuery);
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "User already exists. Please login.";
    } else {
        // Insert new user into database
        $insertUserQuery = "INSERT INTO users (login, password, name, surname, country, city) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("ssssss", $login, $password, $name, $surname, $country, $city);
        if ($stmt->execute()) {
            echo "New user registered successfully<br>";
            header("Location: login.php"); // Redirect to login page after successful registration
            exit();
        } else {
            $error = "Error inserting user: " . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}

function sanitize_input($conn, $data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}
?>