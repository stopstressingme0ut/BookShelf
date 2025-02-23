<?php 
include '../../database/Config.php';
session_start(); 

if (!isset($_SESSION['email'])) {
    header('Location: ../../loginAuth/login.php'); 
    exit;
}

$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $isbn = mysqli_real_escape_string($Conn, $_POST['isbn']);
        $sql = "DELETE FROM book WHERE ISBN = '$isbn'";
        $deleted = mysqli_query($Conn, $sql);
        $successMessage = $deleted ? "Book removed successfully." : "ERROR: Could not remove book. " . mysqli_error($Conn);
    }

    if (isset($_POST['add_quantity'])) {
        $isbn = mysqli_real_escape_string($Conn, $_POST['isbn']);
        $quantity = (int)mysqli_real_escape_string($Conn, $_POST['quantity']);
        $sql = "INSERT INTO all_copies_of_books (ISBN) VALUES ('$isbn')";
        for ($i = 0; $i < $quantity; $i++) {
            mysqli_query($Conn, $sql);
        }
        $successMessage = "Quantity added successfully.";
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['update_book'])) {
            $isbn = mysqli_real_escape_string($Conn, $_POST['isbn']);
            $name = mysqli_real_escape_string($Conn, $_POST['name']);
            $edition = mysqli_real_escape_string($Conn, $_POST['edition']);
            $author = mysqli_real_escape_string($Conn, $_POST['author']);
            $publisher = mysqli_real_escape_string($Conn, $_POST['publisher']);
            $image = mysqli_real_escape_string($Conn, $_POST['image']);
    
            $sql = "UPDATE book SET name = '$name', edition = '$edition', author = '$author', publisher = '$publisher', image = '$image' WHERE ISBN = '$isbn'";
            $updated = mysqli_query($Conn, $sql);
            
            // Set the success message
            $successMessage = $updated ? "Book updated successfully." : "ERROR: Could not update book. " . mysqli_error($Conn);
        }
    }
    
}

$sql = "SELECT * FROM book";
$result = mysqli_query($Conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700,800" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script> 
    
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" type="text/css">
    <link rel="shortcut icon" href="../../assets/images/stack-of-books.png" type="image/x-icon">
    <style>
        .nunito {
            font-family: 'nunito', font-sans;
        }
        
        .border-b-1 {
            border-bottom-width: 1px;
        }
        
        .border-l-1 {
            border-left-width: 1px;
        }
       
        
        #sidebar {
            transition: ease-in-out all .5s;
            z-index: 9999;
        }
        
        #sidebar span {
            opacity: 0;
            position: absolute;
            transition: ease-in-out all .1s;
        }
        
        #sidebar:hover {
            width: 200px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            /*shadow-2xl*/
        }
        
        #sidebar:hover span {
            opacity: 1;
        }

        th {
  text-align: center;
}
td {
  vertical-align: middle;
  text-align: center;
}
    </style>

</head>

<body class=" bg-gray-200 font-sans">

    <div class="flex h-screen ">
            <div id="sidebar" class=" w-12 bg-white text-white flex items-center nunito shadow">

        <ul class=" pl-1">
            <li class="my-2 md:my-0">
                <a href="./admins-homepage.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                    <i class="fa-regular fa-book mr-3 pl-2"></i><span class=" inline-block pb-1 md:pb-0 text-sm"> Book Inventory</span>
                </a>
            </li>
             <li class="my-2 md:my-0 ">
                <a href="./adimn-customer-details.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                    <i class="fa-solid fa-user mr-3 pl-2"></i><span class=" inline-block pb-1 md:pb-0 text-sm">Customer Details</span>
                </a>
            </li>
            <li class="my-2 md:my-0 ">
                <a href="./admins-fines-report.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                    <i class="fas fa-tasks fa-fw mr-3 pl-2"></i><span class=" inline-block pb-1 md:pb-0 text-sm">Fine Reports</span>
                </a>
            </li>
           
            <li class="my-2 md:my-0">
                <a href="./admins-assign-delivery.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                    <i class="fa-solid fa-location-dot pl-2 mr-3"></i><span class=" inline-block pb-1 md:pb-0 text-sm">Assign DeliveryMan</span>
                </a>
            </li>

        </ul>
    </div>

    <!--Menu-->
    <nav id="header1" class="bg-gray-100 w-auto flex-1 border-b-1 border-gray-300 order-1 lg:order-2">
        <div class="pb-2">
            <div class="flex h-full justify-between">
            <div class="flex gap-1.5 relative w-full pt-5 pl-12 ">
                <img src="../../assets/images/stack-of-books.png" class="w-8 h-8" alt="">
                 <h1 class="text-blue-600 font-semibold">BookShelf</h1>
            </div>
            

            <!--Menu-->

            <div class="relative inline-block pr-5 pt-5">

                <div class="relative text-sm">
                    <button id="userButton" class="flex items-center focus:outline-none mr-3">
                        <img class="w-8 h-8 rounded-full mr-4" src="../../assets/images/Anik.jpg" alt="Avatar of User"> <span class="hidden md:inline-block">Hi, Admin! </span>
                        <svg class="pl-1 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                            <g>
                                <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"></path>
                            </g>
                        </svg>
                    </button>
                    <div id="userMenu" class="bg-white nunito menu rounded shadow-md absolute mt-12 top-0 right-0 min-w-full overflow-auto z-30 invisible">
                        <ul class="list-reset">
                            <li><a href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">My account</a></li>
                            <li><a href="#" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Notifications</a></li>
                            <li>
                                <hr class="border-t mx-2 border-gray-400">
                            </li>
                            <li><a href="../../loginAuth/logout.php" class="px-4 py-2 block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Logout</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        </div>

        <hr class="border-t mx-2 border-gray-400">


        <div class="container">
            <div class="text-blue-700 font-semibold pt-4 pl-4 text-xl">
                <h1>Book Inventory</h1>
            </div>
            <div class="flex justify-between mt-5 pr-3">
                <a href="./admins-add-new-books.php" class="btn border border-blue-600 px-2 py-1 rounded-lg hover:text-blue-600 hover:bg-white bg-blue-600 text-white ml-5">Add New Book</a>

                <div class="flex justify-around gap-2">
                    <div class="border rounded-lg">
                        <input type="text" id="search" class="bg-white p-1 rounded-lg" placeholder="Search a book">
                    </div>
                    <div>
                        <select id="filter-select" class="bg-white p-1 rounded-lg">
                            <option value="all">All <i class='bx bx-chevron-down'></i></option>
                            <option value="bookname">Book Name</option>
                            <option value="editionno">Edition No</option>
                            <option value="authorname">Author Name</option>
                            <option value="publishername">Publisher Name</option>
                        </select>
                    </div>
                </div>
            </div>
          
            <div class="container mx-auto pt-5">
        <table class="table-auto w-full bg-white shadow-md rounded">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3">Name</th>
                    <th class="p-3">Edition</th>
                    <th class="p-3">Author</th>
                    <th class="p-3">Publisher</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $isbn = $row['ISBN'];
                        $number_of_books_query = "SELECT COUNT(*) AS count FROM all_copies_of_books WHERE ISBN = '$isbn'";              
                        $number_of_books_result = mysqli_query($Conn, $number_of_books_query);
                        $number_of_books = mysqli_fetch_assoc($number_of_books_result)['count'];
                        ?>
                        <tr class="border-b">
                            <td class="p-3"><?= $row['name']; ?></td>
                            <td class="p-3"><?= $row['edition']; ?></td>
                            <td class="p-3"><?= $row['author']; ?></td>
                            <td class="p-3"><?= $row['publisher']; ?></td>
                            <td class="p-3"><?= $number_of_books; ?></td>
                            <td class="p-3">
                                <!-- Add Quantity -->
                                <form method="POST" class="inline">
                                    <input type="hidden" name="isbn" value="<?= $isbn; ?>">
                                    <input type="number" name="quantity" placeholder="Qty" required class="border rounded p-1 w-14">
                                    <button type="submit" name="add_quantity" class="bg-blue-500 text-white px-3 py-1 rounded">Add</button>
                                </form>

                                <!-- Update Book -->
                                <button onclick="openUpdateModal('<?= $isbn; ?>', '<?= $row['name']; ?>', '<?= $row['edition']; ?>', '<?= $row['author']; ?>', '<?= $row['publisher']; ?>', '<?= $row['image']; ?>')" class="bg-yellow-500 text-white px-3 py-1 rounded">Update</button>

                                <!-- Remove Book -->
                                <form method="POST" class="inline">
                                    <input type="hidden" name="isbn" value="<?= $isbn; ?>">
                                    <button type="submit" name="remove" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center p-3'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Update Modal -->
        <div id="updateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-5 rounded shadow-lg w-96">
                <h2 class="text-xl font-bold mb-4">Update Book</h2>
                <form method="POST">
                    <input type="hidden" id="updateIsbn" name="isbn">
                    <div class="mb-3">
                        <label class="block text-gray-700">Name</label>
                        <input type="text" id="updateName" name="name" class="border rounded w-full p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Edition</label>
                        <input type="text" id="updateEdition" name="edition" class="border rounded w-full p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Author</label>
                        <input type="text" id="updateAuthor" name="author" class="border rounded w-full p-2">
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700">Publisher</label>
                        <input type="text" id="updatePublisher" name="publisher" class="border rounded w-full p-2">
                    </div>
                    <div class="mb-3">
                    <label class="block text-gray-700">Image</label>
                        <input class="border rounded w-full p-2" type="file" name="image" id="file">
                        
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="closeUpdateModal()" class="bg-gray-300 px-4 py-2 rounded mr-2">Cancel</button>
                        <button type="submit" name="update_book" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


<script>
       

        var userMenuDiv = document.getElementById("userMenu");
        var userMenu = document.getElementById("userButton");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //User Menu
            if (!checkParent(target, userMenuDiv)) {
                if (checkParent(target, userMenu)) {
                    if (userMenuDiv.classList.contains("invisible")) {
                        userMenuDiv.classList.remove("invisible");
                    } else {
                        userMenuDiv.classList.add("invisible");
                    }
                } else {
                    userMenuDiv.classList.add("invisible");
                }
            }

        }

        function checkParent(t, elm) {
            while (t.parentNode) {
                if (t == elm) {
                    return true;
                }
                t = t.parentNode;
            }
            return false;
        }
    </script>

    <script>
        function openUpdateModal(isbn, name, edition, author, publisher, image) {
            document.getElementById('updateModal').classList.remove('hidden');
            document.getElementById('updateIsbn').value = isbn;
            document.getElementById('updateName').value = name;
            document.getElementById('updateEdition').value = edition;
            document.getElementById('updateAuthor').value = author;
            document.getElementById('updatePublisher').value = publisher;
            document.getElementById('updateImage').value = image;
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }
    </script>

</body>
</html>