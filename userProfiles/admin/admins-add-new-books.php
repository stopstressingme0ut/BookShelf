<?php 
include '../../database/Config.php';
$SuccessMessage="";
session_start(); 
if (!isset($_SESSION['email'])) {
    header('Location: ../../loginAuth/login.php');
    exit;
}
error_reporting(0);

session_start();
if(isset($_POST['submit'])){
$book_name = mysqli_real_escape_string($Conn, $_POST['book_name']);
$isbn = mysqli_real_escape_string($Conn, $_POST['isbn']);
$author_name = mysqli_real_escape_string($Conn, $_POST['author_name']);
$publisher_name = mysqli_real_escape_string($Conn, $_POST['publisher_name']);
$edition_no = mysqli_real_escape_string($Conn, $_POST['edition_no']);
$quantity = mysqli_real_escape_string($Conn, $_POST['quantity']);
$Get_image_name = $_FILES['image']['name'];
$image_Path = "../../../../images/".basename($Get_image_name);


$dummy_quantity=$quantity;
$SuccessMessage="";

$sql = "INSERT INTO book (ISBN, name,  author, edition, publisher, image) VALUES ('$isbn', '$book_name', '$author_name',  '$edition_no', '$publisher_name', '$Get_image_name')";
$sql2 = "INSERT INTO all_copies_of_books (ISBN) VALUES ('$isbn')";
while($dummy_quantity>0)
{
  $inserted=mysqli_query($Conn, $sql2);
  $dummy_quantity--;
}
if(mysqli_query($Conn, $sql) ){
move_uploaded_file($_FILES['image']['tmp_name'], $image_Path);
  $SuccessMessage ="Books added successfully.";
} else{
  $SuccessMessage ="ERROR: Could not able to add books";
}

}

mysqli_close($Conn);
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

        <ul class=" pl-3">
            <li class="my-2 md:my-0">
                <a href="./admins-homepage.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-600 no-underline hover:text-indigo-400">
                    <i class="fa-regular fa-book mr-3 pl-2"></i><span class=" inline-block pb-1 md:pb-0 text-sm"> Book Inventory</span>
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




        <div class="flex items-center justify-center min-h-screen bg-gray-100">
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
    <h1 class="text-2xl font-bold text-blue-600 text-center mb-6">Add New Book</h1>
    <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label for="book_name" class="block font-medium text-gray-700">Book Name:</label>
        <input
          type="text"
          id="book_name"
          name="book_name"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <div>
        <label for="isbn" class="block font-medium text-gray-700">ISBN:</label>
        <input
          type="text"
          id="isbn"
          name="isbn"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <div>
        <label for="author_name" class="block font-medium text-gray-700">Author Name:</label>
        <input
          type="text"
          id="author_name"
          name="author_name"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <div>
        <label for="publisher_name" class="block font-medium text-gray-700">Publisher Name:</label>
        <input
          type="text"
          id="publisher_name"
          name="publisher_name"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <div>
        <label for="edition_no" class="block font-medium text-gray-700">Edition No.:</label>
        <input
          type="text"
          id="edition_no"
          name="edition_no"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <div>
        <label for="quantity" class="block font-medium text-gray-700">Quantity:</label>
        <input
          type="text"
          id="quantity"
          name="quantity"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <div>
        <label for="file" class="block font-medium text-gray-700">Upload Photo:</label>
        <input
          type="file"
          id="file"
          name="image"
          required
          class="w-full mt-1 px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300"
        />
      </div>
      <button
        type="submit"
        name="submit"
        class="w-full py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300"
      >
        Add Book
      </button>
    </form>
    <!-- Success Modal -->
    <div id="successModal" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center hidden">
      <div class="bg-white rounded-lg shadow-lg p-6 w-96">
        <p class="text-green-600 text-center font-bold">Book added successfully!</p>
      </div>
    </div>
  </div>
</div>
</nav>
    
<script>

  const successModal = document.getElementById("successModal");


  <?php if (!empty($SuccessMessage)) : ?>
    successModal.classList.remove("hidden");
    setTimeout(() => {
      successModal.classList.add("hidden");
    }, 3000); 
  <?php endif; ?>

        var userMenuDiv = document.getElementById("userMenu");
        var userMenu = document.getElementById("userButton");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

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
</body>
</html>