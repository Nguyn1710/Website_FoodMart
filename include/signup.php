<?php
$name = '';
$password = '';
$password_confirmation = '';
$email = '';

$nameErrors = '';
$emailErrors = '';
$passErrors = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check if the form fields are set and not empty
    if (empty($_POST["name"])) {
        die("Name is required");
    }

    if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }

    if (empty($_POST["password"])) {
        die("Password is required");
    }


    if (empty($_POST["password_confirmation"]) || $_POST["password"] !== $_POST["password_confirmation"]) {
        die("Passwords must match");
    }

    // Hash the password
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        // Get database connection
        $db = new Database(); // Assuming you have a Database class
        $pdo = $db->getConnect();

        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $pdo->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");

        // Execute the statement
        $stmt->execute([$_POST["name"], $_POST["email"], $password_hash]);

        // Redirect to the success page
        header("Location:index.php");
        exit;

    } catch (PDOException $e) {
        // Handle SQL errors
        if ($e->getCode() === '23000') {
            die("Email already taken");
        } else {
            die("An error occurred: " . $e->getMessage());
        }
    }

}
?>

<br>
<h2 class="w-50 m-auto"> Signup </h2>
<br>
<style>
    input.form-control {
        border: 1px solid #000;
    }
</style>
<form method="post" class="w-50 m-auto" >
    <div class="mb-3">
        <label for="name" class="form-label">UserName:</label>
        <input class="form-control" id="name" name="name" placeholder="Enter Username" value="<?= htmlspecialchars($name) ?>" />
        <span class="text-danger fw-bold"><?= $nameErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input class="form-control" id="email" name="email" placeholder="Enter Email Address" value="<?= htmlspecialchars($email) ?>" />
        <span class="text-danger fw-bold"><?= $emailErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">PassWord:</label>
        <input class="form-control" id="password" name="password" placeholder="Enter Password" value="<?= htmlspecialchars($password) ?>" />
        <span class="text-danger fw-bold"><?= $passErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password:</label>
        <input class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="<?= htmlspecialchars($password_confirmation) ?>" />
    </div>
    <button type="submit" class="btn btn-primary">SignUp</button>
</form>

