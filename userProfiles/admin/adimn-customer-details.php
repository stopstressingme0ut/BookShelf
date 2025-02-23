<?php 
include '../../database/Config.php';
session_start(); 
if (!isset($_SESSION['email'])) {
    header('Location: ../../loginAuth/login.php');
    exit;
}
$sql = "SELECT email, name, contact_no, picture FROM customer";
$result = $Conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" type="text/css">
    <link rel="shortcut icon" href="../../assets//images/stack-of-books.png" type="image/x-icon">
</head>
<body class="bg-gray-100 min-h-screen p-5">

<div class="flex gap-1.5 justify-center pb-8 mt-5">
            <img src="../../assets/images/stack-of-books.png" class="h-8 w-8" alt="">
            <a href="../admin/admins-homepage.php" class="text-2xl font-semibold text-blue-600">BookShelf</a>
        </div>

    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold text-center mb-8">Customer List</h1>
        
        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-5">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Contact No</th>
                        <th class="px-4 py-2 border">Picture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data for each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='border-b hover:bg-gray-100'>";
                            echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['contact_no']) . "</td>";
                            echo "<td class='px-4 py-2 border'><img src='../../assets/images/" . htmlspecialchars($row['picture']) . "' alt='Profile Picture' class='w-16 h-16 rounded-lg'></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='px-4 py-2 text-center'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
