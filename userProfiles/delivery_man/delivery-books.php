<?php
include '../../database/Config.php';
$SuccessMessage = "";
$curr_email = "";
error_reporting(0);

session_start();
if ($_SESSION['email']) {
    $curr_email = $_SESSION['email'];
}
$sql = "SELECT * FROM deliveryman WHERE email='$curr_email'";
$result = mysqli_query($Conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $locationId = $row['location_id'];
}

$sql2 = "SELECT DISTINCT 
            book_location_delivery.delivery_id AS DeliveryID,
            book_location_delivery.copy_id AS CopyId,
            customer.name AS CustomerName,
            customer.contact_no AS ContactNo,
            customer.email AS email, 
            book.name AS BookName,
            book.ISBN AS ISBN,
            location.area AS Area 
        FROM 
            book_location_delivery
        INNER JOIN location ON book_location_delivery.location_id = location.location_id
        INNER JOIN customer ON book_location_delivery.email = customer.email
        INNER JOIN book ON book_location_delivery.ISBN = book.ISBN
        WHERE 
            book_location_delivery.location_id = '$locationId' 
            AND book_location_delivery.location_id = '$locationId' 
            AND book_location_delivery.delivery_date < NOW()";

$result2 = mysqli_query($Conn, $sql2);

if (isset($_POST['submit'])) {
    if (!empty($_POST['book'])) {
        $deliveryIds = $_POST['book'];
        $deliveryIds = array_map(function ($id) use ($Conn) {
            return mysqli_real_escape_string($Conn, $id);
        }, $deliveryIds);

        $deliveryIdsString = "'" . implode("','", $deliveryIds) . "'"; 
        $find_delivery_ids = "SELECT copy_id FROM book_location_delivery WHERE delivery_id IN ($deliveryIdsString)";
        $result3 = mysqli_query($Conn, $find_delivery_ids);

        if ($result3) {
            $copyIds = array();

            while ($row_result = mysqli_fetch_assoc($result3)) {
                $copyIds[] = $row_result['copy_id'];
            }

            $copyIdsString = "'" . implode("','", $copyIds) . "'"; 

            $del_delivery_id = "DELETE FROM book_location_delivery WHERE delivery_id IN ($deliveryIdsString)";
            $delete = mysqli_query($Conn, $del_delivery_id);

            if ($delete) {
                echo "<script>alert('Selected deliveries deleted successfully.');</script>";
                header("Location: index.php");
            } else {
                echo "<script>alert('Failed to delete selected deliveries.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books to be Delivered</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-6">

        <div class="flex gap-1.5 justify-center pb-8 mt-5">
            <img src="../../assets/images/stack-of-books.png" class="h-8 w-8" alt="">
            <a href="../delivery_man/index.php" class="text-2xl font-semibold text-blue-600">BookShelf</a>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 w-11/12 mx-auto">
            <h1 class="text-2xl font-bold mb-6">Delivery Information</h1>

            <form action="" method="POST">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 text-left">
                                <th class="py-2 px-4 border-b">Book Title</th>
                                <th class="py-2 px-4 border-b">Copy ID</th>
                                <th class="py-2 px-4 border-b">Customer Name</th>
                                <th class="py-2 px-4 border-b">Customer Contact</th>
                                <th class="py-2 px-4 border-b">Delivery Address</th>
                                <th class="py-2 px-4 border-b text-center">Delivered</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result2->num_rows > 0) {
                                while ($row = mysqli_fetch_assoc($result2)) {
                            ?>
                                    <tr class="border-b">
                                        <td class="py-2 px-4"><?php echo $row['BookName']; ?></td>
                                        <td class="py-2 px-4"><?php echo $row['CopyId']; ?></td>
                                        <td class="py-2 px-4"><?php echo $row['CustomerName']; ?></td>
                                        <td class="py-2 px-4"><?php echo $row['ContactNo']; ?></td>
                                        <td class="py-2 px-4"><?php echo $row['Area']; ?></td>
                                        <td class="py-2 px-4 text-center">
                                            <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600"
                                                name="book[]" value="<?php echo $row['DeliveryID']; ?>">
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center py-4">No deliveries found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <button type="submit" name="submit"
                    class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Submit
                </button>
            </form>
        </div>
    </div>
</body>

</html>