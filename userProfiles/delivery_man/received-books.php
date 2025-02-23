<?php
include '../../database/Config.php';

// Fetch data from the database with customer details
$sql = "
    SELECT 
        br.retrieval_id, 
        br.copy_id, 
        br.email, 
        br.ISBN, 
        br.retrieval_date, 
        br.location_id,
        b.name AS book_name,
        l.area AS area_name,
        c.name AS customer_name,
        c.contact_no
    FROM 
        book_location_retrieval br
    LEFT JOIN 
        book b ON br.ISBN = b.ISBN
    LEFT JOIN 
        location l ON br.location_id = l.location_id
    LEFT JOIN 
        customer c ON br.email = c.email
";
$result = mysqli_query($Conn, $sql);

if (isset($_POST['submit'])) {
    if (!empty($_POST['retrievals'])) {
        $retrievalIds = array_map(function ($id) use ($Conn) {
            return mysqli_real_escape_string($Conn, $id);
        }, $_POST['retrievals']);

        $retrievalIdsString = "'" . implode("','", $retrievalIds) . "'";

        $deleteSql = "DELETE FROM book_location_retrieval WHERE retrieval_id IN ($retrievalIdsString)";
        $deleteResult = mysqli_query($Conn, $deleteSql);

        if ($deleteResult) {
            echo "<script>alert('Selected rows deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting rows: " . mysqli_error($Conn) . "');</script>";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('No rows selected.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Book Location Retrieval</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col">

        <div class="flex gap-1.5 justify-center mt-10">
            <img src="../../assets/images/stack-of-books.png" class="h-8 w-8" alt="">
            <a href="../delivery_man/index.php" class="text-2xl font-semibold text-blue-600">BookShelf</a>
        </div>

        <div class="container mx-auto p-14">
            <h1 class="text-2xl font-bold mb-3">Book Retrieval Details:</h1>

            <form action="" method="POST" class="bg-white shadow rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="px-4 py-2 text-gray-600 border">Book Name</th>
                                <th class="px-4 py-2 text-gray-600 border">Customer Name</th>
                                <th class="px-4 py-2 text-gray-600 border">Contact Number</th>
                                <th class="px-4 py-2 text-gray-600 border">Customer Email</th>
                                <th class="px-4 py-2 text-gray-600 border">ISBN</th>
                                <th class="px-4 py-2 text-gray-600 border">Retrieval Date</th>
                                <th class="px-4 py-2 text-gray-600 border">Area</th>
                                <th class="px-4 py-2 text-gray-600 border text-center">Retrieved</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border text-center"><?php echo $row['book_name']; ?></td>
                                        <td class="px-4 py-2 border text-center"><?php echo $row['customer_name']; ?></td>
                                        <td class="px-4 py-2 border text-center"><?php echo $row['contact_no']; ?></td>
                                        <td class="px-4 py-2 border text-center"><?php echo $row['email']; ?></td>
                                        <td class="px-4 py-2 border text-center"><?php echo $row['ISBN']; ?></td>
                                        <td class="px-4 py-2 border text-center"><?php echo $row['retrieval_date']; ?></td>
                                        <td class="px-4 py-2 border text-center"><?php echo $row['area_name']; ?></td>
                                        <td class="px-4 py-2 border text-center">
                                            <input type="checkbox" class="form-checkbox text-blue-500" name="retrievals[]"
                                                value="<?php echo $row['retrieval_id']; ?>">
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center px-4 py-2 border'>No data found in the table.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg mt-5"
                        name="submit">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>