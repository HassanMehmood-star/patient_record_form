<?php include("../includes/db.php"); ?>
<?php include("../includes/header.php"); ?>

<table class="w-full mt-4 border">
    <thead>
        <tr>
            <th class="border p-2">ID</th>
            <th class="border p-2">Name</th>
            <th class="border p-2">Department</th>
            <th class="border p-2">Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM patients");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='border p-2'>" . $row['id'] . "</td>";
            echo "<td class='border p-2'>" . $row['name'] . "</td>";
            echo "<td class='border p-2'>" . $row['department'] . "</td>";
            echo "<td class='border p-2'>" . $row['created_at'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php include("../includes/footer.php"); ?>
