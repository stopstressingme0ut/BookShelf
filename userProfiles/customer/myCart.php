<?php
session_start();
if (!isset($_SESSION['email'])) {
 
    header('Location: ../../../loginAuth/login.php');
    exit;
}
include '../../database/Config.php';
$email = $_SESSION['email'];

$sql = "
    SELECT * 
    FROM customer_book 
    JOIN book ON customer_book.ISBN = book.ISBN 
    WHERE customer_book.email = '$email' 
    AND customer_book.return_date > NOW() 
    AND customer_book.ISBN IN (SELECT ISBN FROM book_location_retrieval) 
    AND customer_book.copy_id IN (SELECT copy_id FROM book_location_retrieval)
    ORDER BY customer_book.issue_date DESC 
    LIMIT 1";
$currentlyBorrowedBooks = mysqli_query($Conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">
    <div class="container mx-auto py-10 px-4 w-11/12">
        <!-- Header -->
        <header class="text-center mb-10">
            <div class="flex gap-1.5 justify-center">
                <img src="../../assets/images/stack-of-books.png" class="h-8 w-8" alt="">
                <a href="../customer/index.php" class="text-2xl font-semibold text-blue-600">BookShelf</a>
            </div>

            <p class="text-gray-700 mt-2">Manage your borrowed books easily</p>
        </header>

        <section class="grid grid-cols-2 gap-3">
            <!-- Currently Borrowing Section -->
            <section class="bg-white shadow-md rounded-lg p-6 pb-10 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Currently Borrowing</h2>
                <div class="flex items-center space-x-6">
                    <div>
                        <img src="<?php
                                    if ($currentlyBorrowedBooksresult = mysqli_fetch_assoc($currentlyBorrowedBooks)) {
                                        echo "../../assets/images/" . $currentlyBorrowedBooksresult['image'];
                                    } else {
                                        echo "../../assets/images/no image.jpg";
                                    }
                                    ?>" class="product-image p-2" style="width: 150px; height: 200px;">
                    </div>

                    <div class="flex-1 pl-12 space-y-5">
                        <?php
                        if ($currentlyBorrowedBooksresult) {
                            echo '<p class="text-lg font-medium text-gray-700">Book Name: <span class="font-semibold">' . $currentlyBorrowedBooksresult["name"] . '</span></p>';
                            echo '<p class="text-lg font-medium text-gray-700">Edition No: <span class="font-semibold">' . $currentlyBorrowedBooksresult["edition"] . '</span></p>';
                            echo '<p class="text-lg font-medium text-gray-700">Author Name: <span class="font-semibold">' . $currentlyBorrowedBooksresult["author"] . '</span></p>';
                            echo '<p class="text-lg font-medium text-gray-700">Issue Date: <span class="font-semibold">' . date('d-m-Y', strtotime($currentlyBorrowedBooksresult['issue_date'])) . '</span></p>';
                            echo '<p class="text-lg font-medium text-gray-700">Return Date: <span class="font-semibold">' . date('d-m-Y', strtotime($currentlyBorrowedBooksresult['return_date'])) . '</span></p>';
                        } else {
                            echo "<h4>No books currently borrowed</h4>";
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Payment Section -->
            <section class="bg-white shadow-md rounded-lg p-5 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-8">Payment</h2>
                <div class="space-y-5">

                    <div>
                        <?php

                        if ($currentlyBorrowedBooksresult) {
                            echo '<p class="text-lg pb-5 font-medium text-gray-700">Book Name: <span class="pl-72 font-semibold">' . $currentlyBorrowedBooksresult["name"] . '</span></p>';

                            echo   '<p class="text-lg font-semibold text-gray-800">Delivery Charge: <span class="pl-72 ">120 /-</span></p>';
                        } else {
                            echo "<h4>No books currently borrowed</h4>";
                        }
                        ?>
                    </div>
                    <div class="flex items-center justify-between">
                        <?php

                        if ($currentlyBorrowedBooksresult) {
                            echo   '<p class="text-lg font-semibold text-gray-800">Total Payment:</p>';
                            echo    '<p class="text-lg font-semibold text-gray-800 pr-10">120 /-</p>';
                        } else {
                            echo "<h4>No books currently borrowed</h4>";
                        }
                        ?>


                    </div>
                </div>
                <div class="flex justify-end">
                    <?php
                    if ($currentlyBorrowedBooksresult) {
                        echo '<button class="mt-4 w-32 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700" onclick="openPaymentModal()">Pay Now</button>';
                    }
                    ?>

                </div>




            </section>

        </section>


        <!-- Previously Borrowed Section -->


        <img src="../../assets/images//images-removebg-preview.png" alt="">

    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Payment Details</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closePaymentModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form>
                <div class="mb-4">
                    <label for="cardName" class="block text-sm font-medium text-gray-700">Name on Card</label>
                    <input type="text" id="cardName" name="cardName" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" placeholder="John Doe" required>
                </div>
                <div class="mb-4">
                    <label for="cardNumber" class="block text-sm font-medium text-gray-700">Card Number</label>
                    <input type="text" id="cardNumber" name="cardNumber" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="expiryDate" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                        <input type="text" id="expiryDate" name="expiryDate" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" placeholder="MM/YY" required>
                    </div>
                    <div>
                        <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                        <input type="text" id="cvv" name="cvv" class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" placeholder="123" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <select class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300">
                        <option value="card">Credit/Debit Card</option>
                        <option value="wallet">Digital Wallet</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-400 text-white py-2 px-4 rounded mr-2" onclick="closePaymentModal()">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Pay Now</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }
        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>


    <script>
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.querySelector(modalId).classList.remove('hidden');
            });
        });

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>

</html>