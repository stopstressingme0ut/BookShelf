<?php 
include '../../database/Config.php';
session_start(); 
if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to the login page
    header('Location: ../../loginAuth/login.php');
    exit;
}
$sql = "SELECT name, contact_no, fine_amount, effective_date FROM customer WHERE fine_amount > 0 and effective_date < NOW()";
$result = $Conn->query($sql);
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

        <div class="container mx-auto px-8 py-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-600">Fine Overview</h1>
  </div>
  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <table id="book-table" class="min-w-full table-auto border-collapse">
      <thead>
        <tr class="bg-blue-600 text-white">
          <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Customer Name</th>
          <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Contact No</th>
          <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Fine Amount</th>
          <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wider">Effective Date</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='hover:bg-gray-100'>";
                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $row['name'] . "</td>";
                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $row['contact_no'] . "</td>";
                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $row['fine_amount'] . "</td>";
                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $row['effective_date'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='px-6 py-4 text-center text-sm text-gray-500'>No fine information found!</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>



</nav>
    
<script>
        var userMenuDiv = document.getElementById("userMenu");
        var userMenu = document.getElementById("userButton");

        document.onclick = check;

        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //User Menu
            if (!checkParent(target, userMenuDiv)) {
                // click NOT on the menu
                if (checkParent(target, userMenu)) {
                    // click on the link
                    if (userMenuDiv.classList.contains("invisible")) {
                        userMenuDiv.classList.remove("invisible");
                    } else {
                        userMenuDiv.classList.add("invisible");
                    }
                } else {
                    // click both outside link and outside menu, hide menu
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