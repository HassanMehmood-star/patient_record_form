<?php include("../includes/session.php"); ?>
<?php include("../includes/db.php"); ?>
<?php include("../includes/header.php"); ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $symptoms = $_POST["symptoms"];
    $dept = $_POST["department"];
    $agree = isset($_POST["agree"]) ? 1 : 0;

    $photo = $_FILES["photo"]["name"];
    $tmp_name = $_FILES["photo"]["tmp_name"];
    move_uploaded_file($tmp_name, "../uploads/" . $photo);

    $stmt = $conn->prepare("INSERT INTO patients (name, dob, gender, email, phone, symptoms, department, agree, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssis", $name, $dob, $gender, $email, $phone, $symptoms, $dept, $agree, $photo);
    $stmt->execute();
    echo "<div class='text-green-600 mb-4'>Patient added successfully!</div>";
}
?>

<form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md space-y-4">
    <input type="text" name="name" placeholder="Full Name" class="w-full border p-2 rounded" required>
    <input type="date" name="dob" class="w-full border p-2 rounded" required>

    <div>
        <label>Gender:</label><br>
        <label><input type="radio" name="gender" value="Male" required> Male</label>
        <label><input type="radio" name="gender" value="Female"> Female</label>
    </div>

    <input type="email" name="email" placeholder="Email" class="w-full border p-2 rounded" required>
    <input type="text" name="phone" placeholder="Phone" class="w-full border p-2 rounded" required>
    <textarea name="symptoms" placeholder="Symptoms" class="w-full border p-2 rounded" required></textarea>

    <select name="department" class="w-full border p-2 rounded" required>
        <option value="">Select Department</option>
        <option value="Cardiology">Cardiology</option>
        <option value="Neurology">Neurology</option>
        <option value="Pediatrics">Pediatrics</option>
    </select>

    <input type="file" name="photo" class="w-full border p-2 rounded" required>

    <label><input type="checkbox" name="agree" required> I confirm this info is correct</label>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Patient</button>
</form>

<?php include("../includes/footer.php"); ?>
