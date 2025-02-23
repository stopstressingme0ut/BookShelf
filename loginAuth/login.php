<?php  

include '../database/Config.php';

error_reporting(0);

session_start();

// the user is already logged in or not
if (isset($_SESSION['email'])) {
    switch ($_SESSION['role']) {
        case "admin":
            header("Location: ../userProfiles/admin/admins-homepage.php"); 
            break;
        case "Reader":
            header("Location: ../userProfiles/customer/index.php");
            break;
        case "DeliveryMan":
            header("Location: ../userProfiles/delivery_man/index.php"); 
            break;
        default:
            header("Location: ../BookShelf/loginAuth/login.php");
            break;
    }
    exit();
}


$WrongUser = $WrongPass = "";

if (isset($_POST['submit'])) {
   
    $email = mysqli_real_escape_string($Conn, $_POST['email']);
    $password = mysqli_real_escape_string($Conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($Conn, $sql);

    if ($result && $result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($password === $row['password']) {
      
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // Redirect user based on their role
            switch ($_SESSION['role']) {
                case "Reader":
                    $sql_customer = "SELECT * FROM customer WHERE email='$email'";
                    $result_customer = mysqli_query($Conn, $sql_customer);
                    if ($result_customer && $res_customer = mysqli_fetch_assoc($result_customer)) {
                        $_SESSION['user_name'] = $res_customer['name'];
                    }
                    header("Location: ../userProfiles/customer/index.php");
                    break;

                case "DeliveryMan":
                    $sql_deliveryman = "SELECT * FROM deliveryman WHERE email='$email'";
                    $result_deliveryman = mysqli_query($Conn, $sql_deliveryman);
                    if ($result_deliveryman && $res_deliveryman = mysqli_fetch_assoc($result_deliveryman)) {
                        $_SESSION['user_name'] = $res_deliveryman['name'];
                    }
                    header("Location: ../userProfiles/delivery_man/index.php");
                    break;

                case "admin":
                default:
                    header("Location: ../userProfiles/admin/admins-homepage.php");
                    break;
            }
            exit();
        } else {
            $WrongPass = "Wrong Password.";
        }
    } else {
        $WrongUser = "Invalid Email.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>BookShelf-Log In</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="shortcut icon" href="../assets/images/stack-of-books.png" type="image/x-icon">

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</head>
<body>
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img class="w-8 h-8 mr-2" src="../assets/images/stack-of-books.png" alt="logo">
          BookShelf    
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Sign in to your account
              </h1>
              <form class="space-y-4 md:space-y-6" action="" method="POST">
    <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="e.g. name@gmail.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
        <span class="text-red-500"><?php echo $WrongUser; ?></span>
    </div>
    <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        <span class="text-red-500"><?php echo $WrongPass; ?></span>
    </div>
    <p class="text-white text-sm mt-4 text-center">Don't you have an account? <a href="../loginAuth/signup.php" class="text-blue-400 font-semibold hover:underline ml-1">Register here</a></p>

    <button type="submit" name="submit" class="w-full bg-blue-600 text-white bg-primary-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:text-black dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
    </form>

          </div>
      </div>
  </div>
</section>

</body>
</html>

