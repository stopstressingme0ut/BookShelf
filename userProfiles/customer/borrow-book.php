<?php
include '../../database/Config.php';

session_start(); 
if (!isset($_SESSION['email'])) {
    header('Location: ../../../LoginAuth/login.php');
    exit;
}

if (isset($_GET['ISBN'])) {
    $ISBN = $_GET['ISBN'];
    $sql = "SELECT * FROM book WHERE ISBN = '$ISBN'";
    $result = mysqli_query($Conn, $sql);
    $disabled = "";

    if (mysqli_num_rows($result)) {
        $email = $_SESSION['email'];

        $sql = "SELECT count(*) as count FROM all_copies_of_books WHERE ISBN = '$ISBN' AND borrowed = 0";
        $res = mysqli_query($Conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $count = $row['count'];

        $sql = "SELECT count(*) as count FROM customer_book WHERE email = '$email' AND return_date > NOW()";
        $res = mysqli_query($Conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $count2 = $row['count'];

        $book = mysqli_fetch_assoc($result);

        if (isset($_POST['submit'])) {
            $duration = $_POST['duration'];
            $area = mysqli_real_escape_string($Conn, $_POST['location']);
            
            $sql = "SELECT DATE_ADD(NOW(), INTERVAL 7 * $duration DAY) as return_date";
            $result = mysqli_query($Conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $return_date = $row['return_date'];

            $sql = "SELECT location_id FROM location WHERE area = '$area'";
            $result = mysqli_query($Conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $location_id = $row['location_id'];

            $order_id = uniqid();
            $sql = "SELECT copy_id FROM all_copies_of_books WHERE ISBN = '$ISBN' AND borrowed = 0";
            $result = mysqli_query($Conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $copy_id = $row['copy_id'];

            // Insert into customer_book
            $sql = "INSERT INTO customer_book (email, ISBN, copy_id, return_date, issue_date) 
                    VALUES ('$email', '$ISBN', '$copy_id', '$return_date', NOW())";
            $result1 = mysqli_query($Conn, $sql);

            // Insert into book_location_delivery
            $sql = "INSERT INTO book_location_delivery (delivery_id, email, ISBN, copy_id, location_id, delivery_date) 
                    VALUES ('$order_id', '$email', '$ISBN', '$copy_id', '$location_id', NOW())";
            $result2 = mysqli_query($Conn, $sql);

            // Insert into book_location_retrieval
            $retrieval_id = uniqid();
            $sql = "INSERT INTO book_location_retrieval (retrieval_id, email, ISBN, copy_id, location_id, retrieval_date) 
                    VALUES ('$retrieval_id', '$email', '$ISBN', '$copy_id', '$location_id', '$return_date')";
            $result3 = mysqli_query($Conn, $sql);

            // Update book status to borrowed
            if ($result1 && $result2 && $result3) {
                $sql = "UPDATE all_copies_of_books SET borrowed = 1 WHERE copy_id = '$copy_id' AND ISBN = '$ISBN'";
                mysqli_query($Conn, $sql);
                echo '<script>alert("Order Placed Successfully")</script>';
            } else {
                echo '<script>alert("Order Failed")</script>';
            }

            header("Location: ./myCart.php"); 
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex">
            <div class="w-1/3">
                <img src="../../assets/images/<?php echo $book['image']; ?>" alt="<?php echo $book['name']; ?>"
                    class="w-full h-auto p-5 ml-8">
            </div>
            <div class="w-2/3 p-5 pl-20">
                <h2 class="text-2xl font-semibold mb-8"><?php echo $book['name']; ?></h2>

                <p class="text-lg mb-2">ISBN: <?php echo $book['ISBN']; ?></p>
                <p class="text-lg mb-2">Author: <?php echo $book['author']; ?></p>
                <p class="text-lg mb-2">Publisher: <?php echo $book['publisher']; ?></p>
                <p class="text-lg mb-2">Edition: <?php echo $book['edition']; ?></p>
                <button class="bg-blue-500 text-white py-2 px-4 mt-12 rounded hover:bg-blue-600 transition"
                    data-modal-target="#borrowModal" <?php echo $disabled; ?>>Borrow Book</button>
            </div>
        </div>
    </div>

    <div id="borrowModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg w-1/3 p-6">
        <h2 class="text-xl font-semibold mb-4">Borrow Book</h2>
        <form method="POST">
            <div class="mb-4">
                <label for="duration" class="block text-lg font-medium mb-2">Duration (Weeks)</label>
                <select name="duration" id="duration"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-lg font-medium mb-2">Select Area</label>
                <select name="location" id="location"
                        class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                    <option value="" disabled selected>Select an area</option>
                    <?php
                    $location_query = "SELECT DISTINCT area FROM location";
                    $location_result = mysqli_query($Conn, $location_query);
                    while ($location_row = mysqli_fetch_assoc($location_result)) {
                        echo "<option value='" . $location_row['area'] . "'>" . $location_row['area'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- New field to show the delivery point -->
            <div class="mb-4">
                <label for="delivery_point" class="block text-lg font-medium mb-2">Delivery Point</label>
                <input type="text" id="delivery_point" class="w-full border rounded px-3 py-2" disabled>
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-400 text-white py-2 px-4 rounded mr-2"
                        onclick="document.getElementById('borrowModal').classList.add('hidden')">Cancel</button>
                <button type="submit" name="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Confirm</button>
            </div>
        </form>
    </div>
</div>


    <script>
        document.querySelector('[data-modal-target]').addEventListener('click', function () {
            document.getElementById('borrowModal').classList.remove('hidden');
        });

        
    document.querySelector('[data-modal-target]').addEventListener('click', function () {
        document.getElementById('borrowModal').classList.remove('hidden');
    });

    document.getElementById('location').addEventListener('change', function () {
        var selectedArea = this.value;
        
        if (selectedArea) {
            fetchDeliveryPoint(selectedArea);
        }
    });

    function fetchDeliveryPoint(area) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'getDeliveryPoint.php?area=' + encodeURIComponent(area), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('delivery_point').value = xhr.responseText;
            }
        };
        xhr.send();
    }


    </script>
</body>

</html>

<?php
    } else {
        echo "<p class='text-center text-red-500'>Book not found.</p>";
    }
    mysqli_close($Conn);
} else {
    header('Location: ./myCart.php');
    exit;
}
?>
