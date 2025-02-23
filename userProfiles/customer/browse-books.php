<?php 
include '../../database/Config.php';
session_start(); 

if(isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    
    $sql = "SELECT * FROM book WHERE author LIKE CONCAT('%', ?, '%') OR name LIKE CONCAT('%', ?, '%')";
    
    $stmt = mysqli_prepare($Conn, $sql);
    
    mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
    
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT * FROM book";
    $result = mysqli_query($Conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon -->
    <link rel="shortcut icon" href="../../assets/images/stack-of-books.png" type="image/x-icon">
    
    <!-- CSS link -->
    <link rel="stylesheet" href="../../assets/css/styles.css">

    <!-- Tailwind & DaisyUI cdn -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.12/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper cdn -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Google font  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Font Awesome cdn -->
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css" type="text/css">

    <title>BookShelf - Borrow Your Favorite Books</title>
</head>
<body class="montserrat-font">
    <header class="bg-gradient-to-t from-slate-300 to-slate-100 pb-10">
      <!-- navbar starts here -->
       <nav class="container mx-auto lg:w-4/5">
        <div class="navbar pt-6 flex ">
          <div class="navbar-start flex gap-1">
            <img src="../../assets/images/stack-of-books.png" class="w-6 h-6" alt="">
            <a href="#" class="text-blue-600 font-semibold text-lg">BookShelf</a>
          

          </div>
          <div class="navbar-center hidden font-medium text-black lg:flex">
            <ul class="menu menu-horizontal px-1 font-[400]">
              <li class="font-semibold hover:text-blue-600 duration-300 ease-in-out"><a href="./index.php">Home</a></li>
              <li class="hover:font-semibold hover:text-blue-600 hover: duration-300 ease-in-out"><a href="./browse-books.php">Browse Books</a></li>
              <li class="hover:font-semibold hover:text-blue-600 duration-300 ease-in-out"><a href="#sub">Contact Us</a></li>
            </ul>
          </div>
          <div class="relative inline-block ">

                <div class="relative text-sm pl-5">
                    <button id="userButton" class="flex items-center focus:outline-none gap-1">
                        <span class="hidden md:inline-block text-blue-600 font-semibold">Hi, User! </span>
                        <svg class="pl-1 h-2" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                            <g>
                                <path d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"></path>
                            </g>
                        </svg>
                    </button>
                    <div id="userMenu" class="bg-white nunito menu rounded shadow-md absolute overflow-x-auto text-wrap z-30 mt-3 invisible">
                        <ul class="">
                            <li><a href="../../userProfiles/customer/profile.php" class="w-28 text-gray-900 hover:bg-indigo-400 hover:text-white ">My Profile</a></li>
                            
                               <hr>
                            
                            <li><a href="../../loginAuth/logout.php" class="block text-gray-900 hover:bg-indigo-400 hover:text-white no-underline hover:no-underline">Logout</a></li>
                        </ul>
                    </div>
                </div>

            </div>
          
        </div>
       </nav>
         <!-- Banner part starts here  -->
    <section class="container mx-auto lg:w-4/5 pt-20">
      <div class=" relative">
        <div class=" rounded-2xl h-auto md:h-96 flex flex-col md:flex-row p-6 gap-4 md:gap-5 items-center">
            <!-- Static Text Section -->
            <div
                class="flex flex-col gap-4 md:gap-6 py-4 md:py-4 md:px-6 justify-center h-auto md:h-full basis-full md:basis-1/2">
                <h2 class="text-gray-700 font-bold text-lg mt-7 md:text-2xl">Browse & <br> Borrow Your Favorite Books!</h2>
                <p class="text-gray-950 text-sm sm:text-base md:text-lg">Find the best books from your favorite writers, explore hundreds of books with all possible categories and much more!
                </p>
                <a href="https://example.com" target="_blank" class="inline-block">
                    <button type="button"
                        class="text-black bg-blue-400 hover:bg-blue-600 hover:text-white focus:outline-none font-medium rounded-xl text-m px-6 py-3">
                        Explore Now
                    </button>
                </a>
            </div>

            <!-- Sliding Image Section -->
            <div class="swiper default-carousel swiper-container h-64 md:h-full basis-full md:basis-1/4">
                <div class="swiper-wrapper h-full">
                    <div class="swiper-slide flex-shrink-0 h-full">
                        <img src="../../assets/images/home-book-1.png" alt="book"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="swiper-slide flex-shrink-0 h-full">
                        <img src="../../assets/images/home-book-2.png" alt="book"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="swiper-slide flex-shrink-0 h-full">
                        <img src="../../assets/images/home-book-3.png" alt="book"
                            class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="swiper-slide flex-shrink-0 h-full">
                      <img src="../../assets/images/home-book-4.png" alt="book"
                          class="w-full h-full object-cover rounded-lg">
                  </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="swiper-pagination"></div>

            </div>
        </div>
    </div>
    </section>
    </header>


    <main class="container mx-auto lg:w-4/5 pt-10">
        <form action="" method="GET" class="mb-6 flex justify-between">
            <div>
                <a href="./browse-books.php" class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors">Show All</a>
            </div>
            <div class="flex items-center">
                <input 
                    type="text" 
                    name="search_query" 
                    placeholder="Search by author or book name" 
                    class="w-80 px-3 py-1 border border-gray-300 rounded-l-lg focus:outline-none focus:ring focus:ring-blue-300"
                    value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>">
                <button 
                    type="submit" 
                    class="bg-blue-600 text-white px-3 py-1.5 rounded-r-lg hover:bg-blue-700 transition-colors">
                    Search
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-gray-200 shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src=" ../../assets/images/<?php echo $row['image']; ?>" alt="Book Cover" class="w-36 h-48 mt-2  ml-11">
                        <hr>
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800 truncate"><?php echo htmlspecialchars($row['name']); ?></h2>
                            <p class="text-sm text-gray-500 mt-1">ISBN:- <span class="font-medium text-gray-700"><?php echo htmlspecialchars($row['ISBN']); ?></span></p>
                            <p class="text-sm text-gray-500 mt-1">Author:- <span class="font-medium text-gray-700"><?php echo htmlspecialchars($row['author']); ?></span></p>
                            <p class="text-sm text-gray-500 mt-1">Publisher:- <span class="font-medium text-gray-700"><?php echo htmlspecialchars($row['publisher']); ?></span></p>
                            <p class="text-sm text-gray-500 mt-1">Edition:- <span class="font-medium text-gray-700"><?php echo htmlspecialchars($row['edition']); ?></span></p>
                        </div>
                        <div class="pb-4 ">
                        <a href="./borrow-book.php?ISBN=<?php echo $row['ISBN'] ?>" class=" ml-4 mb-4 px-20 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">Rent</a>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-600">No books found.</p>
            <?php endif; ?>
        </div>

    </main>


   
    
 <section id="sub" class="relative h-[400px] pl-24 bg-cover bg-center mt-5" style="background-image: url('../../assets/images/join-bg.jpg');">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative flex flex-col  h-full text-left pl-8 text-white px-4 pt-24">
      <h1 class="text-3xl md:text-3xl font-bold mb-4">
        Subscribe To Receive <br> The Latest Updates
      </h1>
      <p class="text-lg mb-8">
        Stay informed with our updates. Join our mailing list today!
      </p>

      <!-- Form -->
      <form action="#" method="POST" class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
        <input 
          type="email" 
          placeholder="Enter your email" 
          required
          class="w-full sm:w-64 px-3 py-2.5 text-gray-800 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button 
          type="submit" 
          class="px-4 py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
          Subscribe
        </button>
      </form>
    </div>
  </section>



  
    
  <footer class="footer bg-black flex lg:flex-col pt-5 py-5 flex-col" id="footer">
        <div class="flex lg:flex-row flex-col items-baseline lg:justify-between container   mx-auto lg:w-4/5 w-11/12">
            <div>
                <div class="flex lg:gap-2 items-center">
                    <img class="h-7 w-7" src="../../assets//images/stack-of-books.png" alt="Logo">
                    <h3 class="text-xl text-white font-bold">BookShelf</h3>
                </div>
                <div class="pt-5 space-y-2">
                    <p class="text-[#FFFFFFE6] font-[400]">Location: Madani Avenue(100ft),Satarkul,Badda</p>
                    <p class="text-[#FFFFFFE6] font-[400]">Phone: +8801723943373</p>
                    <p class="text-[#FFFFFFE6] font-[400]">Email: rahmed203034@bscse.uiu.ac.bd</p>
                    <p class="text-[#FFFFFFE6] font-[400]">Openings hours: 9.00 AM - 5.00 PM</p>
                </div>
                <div class="flex items-center pt-5 pb-5 gap-3">
                    <img class="h-8 w-8" src="../../assets/images/2023_Facebook_icon.svg.webp" alt="">
                    <img class="h-9 w-9" src="../../assets/images/X_logo.jpg" alt="">
                    <img class="h-8 w-10" src="../../assets/images/yt-6273367_640.webp" alt="">
                    <img class="h-9 w-9 rounded-lg" src="../../assets/images/insta.jpg" alt="">
                </div>
            </div>
            <div class="space-y-2">
                <p class="text-white text-lg font-[600] pb-3">Useful Links</p>
                <p class="text-[#FFFFFF99]">Home</p>
                <p class="text-[#FFFFFF99]">About Us</p>
                <p class="text-[#FFFFFF99]">Contact</p>
            </div>
            <div class="space-y-3">
                <p class="text-white text-lg font-[550] ">Drop a Message</p>
                <input type="text" placeholder="Enter your email" class="input input-bordered join-item" /> <br>
                <button
                    class="btn border-none w-full text-white text-[16px] bg-blue-600 rounded-lg px-6 hover:bg-black">Subscribe</button>
            </div>
        </div>
        <div class="pb-5 mx-auto">
            <p class="font-[400] text-sm  text-white tracking-wider"><i class="fa-solid fa-code text-blue-600"
                    ></i> with <i class="fa-solid fa-heart" style="color: #ff0000;"></i> By Rafi
                Ahmed - All rights are reserved © <a href="#" class="text-blue-600 font-semibold">BookShelf</a></p>
        </div>
    </footer>



     <!--=============== MAIN JS ===============-->
     <script src="../../assets/js/main.js"></script>
     
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