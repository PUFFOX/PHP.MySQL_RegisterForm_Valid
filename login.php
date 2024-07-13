<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="form-container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="loginForm">
        <h2>Login</h2>
        <label for="login">Login:</label>
        <input type="text" id="login" name="login">
        <span id="loginError" class="error"></span>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span id="passwordError" class="error"></span>

        <button type="submit" id="submitButton" disabled>Submit</button>
    </form>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
</div>

</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let inputs = document.querySelectorAll('#loginForm input');

        inputs.forEach(input =>
        {
            input.addEventListener('keyup', function () {
                validateField(this.id);
            });
        });
    });

    function validateField(field)
    {
        let value = document.getElementById(field).value.trim();
        let errorField = document.getElementById(field + 'Error');
        let isValid = true;
        let errorMessage = "";

        switch (field) {
            case 'login':
                if (value.length === 0)
                {
                    isValid = false;
                    errorMessage = "Login is required";
                }
                break;
            case 'password':
                if (value.length === 0)
                {
                    isValid = false;
                    errorMessage = "Password is required";
                }
                break;
            default:
                isValid = true;
        }

        if (!isValid)
        {
            errorField.textContent = errorMessage;
        } else {
            errorField.textContent = "";
        }

        validateForm();
    }

    function validateForm()
    {
        let login = document.getElementById('login').value.trim();
        let password = document.getElementById('password').value.trim();

        let isFormValid = login.length > 0 && password.length > 0;

        document.getElementById('submitButton').disabled = !isFormValid;
    }
</script>

<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Connect to MySQL database
    $conn = new mysqli("localhost", "root", "", "HW0206DB");
    if ($conn->connect_error)
    {
        echo "Connection error: " . $conn->connect_error;
        die();
    }

    // Sanitize and validate input data
    $login = sanitize_input($conn, $_POST['login']);
    $password = sanitize_input($conn, $_POST['password']);

    // Check if user exists
    $checkUserQuery = "SELECT * FROM users WHERE login = ? AND password = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1)
    {
        // User exists, redirect to index.php or any other desired page
        header("Location: main.php");
        exit();
    } else {
        $error = "Invalid login or password";
    }

    $stmt->close();
    $conn->close();
}

function sanitize_input($conn, $data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}
?>