<?php
// Start the session (only if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Record System</title>
    <!-- Tailwind CDN (no need to download file) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">🏥 Patient Record</h1>
            <div class="space-x-4">
                <a href="/patient_record_form/public/index.php" class="hover:underline">Home</a>
                <a href="/patient_record_form/public/add_patient.php" class="hover:underline">Add Patient</a>
                <a href="/patient_record_form/public/view_patients.php" class="hover:underline">View Patients</a>
            </div>
        </div>
    </nav>

    <!-- Main content wrapper -->
    <main class="container mx-auto mt-6 px-4">
