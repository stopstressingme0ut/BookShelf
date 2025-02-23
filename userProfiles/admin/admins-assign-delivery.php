<?php
include '../../database/Config.php';

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../../loginAuth/login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $area = $_POST['area'];
    $sql = "SELECT location_id FROM location WHERE area='$area' LIMIT 1";
    $result = mysqli_query($Conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $location_id = $row['location_id'];
    $email = $_POST['email'];

    $updateSql = "UPDATE deliveryman SET location_id='$location_id' WHERE email='$email'";
    mysqli_query($Conn, $updateSql);

    $updateSql = "UPDATE deliveryman SET area='$area' WHERE email='$email'";
    mysqli_query($Conn, $updateSql);
}

$sql = "SELECT deliveryman.name, deliveryman.email, location.area 
        FROM deliveryman 
        LEFT JOIN location ON deliveryman.location_id = location.location_id";
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
        <div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6 text-blue-600">Assign Location</h1>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full border-collapse">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-center font-medium">Name</th>
                    <th class="px-6 py-3 text-center font-medium">Email</th>
                    <th class="px-6 py-3 text-center font-medium">Area</th>
                    <th class="px-6 py-3 text-center font-medium">Assign</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-gray-700"><?php echo $row['name']; ?></td>
                    <td class="px-6 py-4 text-gray-700"><?php echo $row['email']; ?></td>
                    <td class="px-6 py-4 text-gray-700"><?php echo $row['area'] ?? 'Unassigned'; ?></td>
                    <!-- Assign Button -->
            <td class="px-6 py-4">
                <button 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700" 
                    onclick="openModal('modal-<?php echo $row['email']; ?>')">
                    Assign
                </button>
            </td>

<!-- Modal -->
<div 
    id="modal-<?php echo $row['email']; ?>" 
    class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-96">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold text-blue-700">Assign Area</h2>
        </div>
        <form action="" method="POST" class="p-4">
            <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
            <label for="area" class="block text-gray-700 font-medium mb-2 pl-5">Area:</label>
            <select name="area" id="area" class="w-80 px-3 py-2 border rounded-lg ml-3">
                <option value="" selected>Select Area</option>
                <?php
                $areaQuery = "SELECT DISTINCT area FROM location";
                $areas = mysqli_query($Conn, $areaQuery);
                while ($areaRow = mysqli_fetch_assoc($areas)) {
                    echo "<option value='{$areaRow['area']}'>{$areaRow['area']}</option>";
                }
                ?>
            </select>
            <div class="mt-4 flex justify-end space-x-2 mr-3 mb-3">
                <button type="button" 
                        class="bg-gray-300 px-4 py-2 rounded-lg" 
                        onclick="closeModal('modal-<?php echo $row['email']; ?>')">
                    Cancel
                </button>
                <button type="submit" name="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Assign
                </button>
            </div>
        </form>
    </div>
</div>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>



</nav>

<script>
    // Function to open the modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    // Function to close the modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
    
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
</body>
</html>