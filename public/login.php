<?php
session_start();
require_once('../includes/db.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // ✅ Comparing plain-text password (temporary testing only)
            if ($password === $user['password']) {
                $_SESSION["user_id"] = $user['id'];
                $_SESSION["username"] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}
?>

<?php include("../includes/header.php"); ?>

<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
    <?php if (!empty($error)) : ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" class="mt-1 w-full border border-gray-300 p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="mt-1 w-full border border-gray-300 p-2 rounded" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>
</div>

<?php include("../includes/footer.php"); ?>
