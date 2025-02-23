<?php

include '../database/Config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] === "Reader") {
        header("Location: ../userProfiles/customer/index.php");
    } else {
        header("Location: ../userProfiles/delivery_man/index.php");
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $contact_no = $_POST["contact_no"];
    $role = $_POST['Field'];
    $user_name = $_POST['user_name'];
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
    $_SESSION['user_name'] = $user_name;
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (strlen($contact_no) == 11) {
            if ($password === $cpassword) {
                $check_query = mysqli_query($Conn, "SELECT * FROM users WHERE email ='$email'");
                $rowCount = mysqli_num_rows($check_query);

                if ($rowCount > 0) {
                    $emailErr = "User with email already exists!";
                } else {
                    if ($role === "Reader") {
                        $sql = "INSERT INTO users (email, password, role) 
                                VALUES ('$email', '$password', '$role')";
                        $result = mysqli_query($Conn, $sql);

                        $sql_customer = "INSERT INTO customer (email, name, contact_no, fine_amount) 
                                         VALUES ('$email', '$user_name', '$contact_no', 0)";
                        $result2 = mysqli_query($Conn, $sql_customer);

                        if ($result && $result2) {
                            header("Location: ../userProfiles/customer/index.php");
                        } else {
                            echo "Something went wrong";
                        }
                    } else {
                        $sql = "INSERT INTO users (email, password, role) 
                                VALUES ('$email', '$password', '$role')";
                        $result = mysqli_query($Conn, $sql);

                        $sql_deliveryman = "INSERT INTO deliveryman (email, name, contact_no) 
                                            VALUES ('$email', '$user_name', '$contact_no')";
                        $result2 = mysqli_query($Conn, $sql_deliveryman);

                        if ($result && $result2) {
                            header("Location: ../userProfiles/delivery_man/index.php");
                        } else {
                            echo "Something went wrong";
                        }
                    }
                }
            } else {
                $ConfirmErr = "Passwords do not match";
            }
        } else {
            $contactErr = "Contact number must be 11 digits long";
        }
    } else {
        $emailErr = "Invalid Email";
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../assets/images/stack-of-books.png" type="image/x-icon">

    <title>BookShelf-Sign Up</title>
</head>
<body class="pt-5">
 
    <div class="font-[sans-serif] bg-gray-50 flex items-center md:h-screen p-4">
      <div class="w-full max-w-3xl max-md:max-w-xl mx-auto">
        <div class="bg-white grid md:grid-cols-2 gap-12 w-full sm:p-8 p-6 shadow-md rounded-md overflow-hidden">
          <div class="max-md:order-1 space-y-6">
            <div class="text-center pb-14">
                <img class="w-20 h-20 mx-auto mb-5" src="../assets/images/stack-of-books.png" alt="">
                <h2 class="font-bold text-[35px] mb-2 text-blue-600">BookShelf</h2>
                <p class="">An Online Book Borrowing Platform</p>
            </div>

            <div class="md:mb-16 mb-8">
              <h3 class="text-gray-800 text-xl">Instant Access</h3>
            </div>

            <div class="space-y-4">
              <button type="button"
                class="px-4 py-2.5 flex items-center justify-center rounded-md text-white text-sm tracking-wider border-none outline-none bg-blue-600 hover:bg-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="22px" fill="#fff" class="inline shrink-0 mr-3" viewBox="0 0 167.657 167.657">
                  <path
                    d="M83.829.349C37.532.349 0 37.881 0 84.178c0 41.523 30.222 75.911 69.848 82.57v-65.081H49.626v-23.42h20.222V60.978c0-20.037 12.238-30.956 30.115-30.956 8.562 0 15.92.638 18.056.919v20.944l-12.399.006c-9.72 0-11.594 4.618-11.594 11.397v14.947h23.193l-3.025 23.42H94.026v65.653c41.476-5.048 73.631-40.312 73.631-83.154 0-46.273-37.532-83.805-83.828-83.805z"
                    data-original="#010002" />
                </svg>
                Continue with Facebook
              </button>
              <button type="button"
                class="px-4 py-2.5 flex items-center justify-center rounded-md text-gray-800 text-sm tracking-wider border-none outline-none bg-gray-100 hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="22px" fill="#fff" class="inline shrink-0 mr-3" viewBox="0 0 512 512">
                  <path fill="#fbbd00"
                    d="M120 256c0-25.367 6.989-49.13 19.131-69.477v-86.308H52.823C18.568 144.703 0 198.922 0 256s18.568 111.297 52.823 155.785h86.308v-86.308C126.989 305.13 120 281.367 120 256z"
                    data-original="#fbbd00" />
                  <path fill="#0f9d58"
                    d="m256 392-60 60 60 60c57.079 0 111.297-18.568 155.785-52.823v-86.216h-86.216C305.044 385.147 281.181 392 256 392z"
                    data-original="#0f9d58" />
                  <path fill="#31aa52"
                    d="m139.131 325.477-86.308 86.308a260.085 260.085 0 0 0 22.158 25.235C123.333 485.371 187.62 512 256 512V392c-49.624 0-93.117-26.72-116.869-66.523z"
                    data-original="#31aa52" />
                  <path fill="#3c79e6"
                    d="M512 256a258.24 258.24 0 0 0-4.192-46.377l-2.251-12.299H256v120h121.452a135.385 135.385 0 0 1-51.884 55.638l86.216 86.216a260.085 260.085 0 0 0 25.235-22.158C485.371 388.667 512 324.38 512 256z"
                    data-original="#3c79e6" />
                  <path fill="#cf2d48"
                    d="m352.167 159.833 10.606 10.606 84.853-84.852-10.606-10.606C388.668 26.629 324.381 0 256 0l-60 60 60 60c36.326 0 70.479 14.146 96.167 39.833z"
                    data-original="#cf2d48" />
                  <path fill="#eb4132"
                    d="M256 120V0C187.62 0 123.333 26.629 74.98 74.98a259.849 259.849 0 0 0-22.158 25.235l86.308 86.308C162.883 146.72 206.376 120 256 120z"
                    data-original="#eb4132" />
                </svg>
                Continue with Google
              </button>
              <button type="button"
                class="px-4 py-2.5 flex items-center justify-center rounded-md text-white text-sm tracking-wider border-none outline-none bg-black hover:bg-[#222]">
                <svg xmlns="http://www.w3.org/2000/svg" width="22px" fill="#fff" class="inline shrink-0 mr-3" viewBox="0 0 22.773 22.773">
                  <path
                    d="M15.769 0h.162c.13 1.606-.483 2.806-1.228 3.675-.731.863-1.732 1.7-3.351 1.573-.108-1.583.506-2.694 1.25-3.561C13.292.879 14.557.16 15.769 0zm4.901 16.716v.045c-.455 1.378-1.104 2.559-1.896 3.655-.723.995-1.609 2.334-3.191 2.334-1.367 0-2.275-.879-3.676-.903-1.482-.024-2.297.735-3.652.926h-.462c-.995-.144-1.798-.932-2.383-1.642-1.725-2.098-3.058-4.808-3.306-8.276v-1.019c.105-2.482 1.311-4.5 2.914-5.478.846-.52 2.009-.963 3.304-.765.555.086 1.122.276 1.619.464.471.181 1.06.502 1.618.485.378-.011.754-.208 1.135-.347 1.116-.403 2.21-.865 3.652-.648 1.733.262 2.963 1.032 3.723 2.22-1.466.933-2.625 2.339-2.427 4.74.176 2.181 1.444 3.457 3.028 4.209z"
                    data-original="#000000" />
                </svg>
                Continue with Apple
              </button>
            </div>
          </div>

          <form class="w-full" method="POST">
            <div class="mb-8">
              <h3 class=" text-blue-600 text-xl">Register</h3>
            </div>
            <div>
            <h5 class="text-center pb-2">Choose a role:</h5>
            <h6 class="text-center">
              <input type="radio" name="Field" value="Reader" required /> Customer 
             <input type="radio" name="Field" value="DeliveryMan" required /> Delivery Man<br>
            </h6>
            </div>

            <div class="pt-2">
            
            <input type="text" class="container p-2 mb-2 border border-blue-400 rounded-lg" name="user_name" autofocus placeholder="Name" autocomplete="off" required>
            

            <input type="text" class="container p-2 mb-2 border border-blue-400 rounded-lg" name="contact_no" autofocus placeholder="Contact No." autocomplete="off"  required>
           
     
            <input type="email" class="container p-2 mb-2 border border-blue-400 rounded-lg" name="email" autofocus placeholder="Email" autocomplete="off"  required>
           
     
            <input type="password" class="container p-2 mb-2 border border-blue-400 rounded-lg" name="password" id="myInput" autofocus placeholder="Password" autocomplete="off"  required>
            <br>
            <input type="checkbox" onclick="myFunction()"><span> Show Password</span><br>
           
     
            <input type="password" class="container p-2 mb-2 border border-blue-400 rounded-lg" name="cpassword" id="myInput2" autofocus placeholder="Confirm Password" autocomplete="off"  required>
            <br>
            <input type="checkbox" onclick="myFunction2()"><span class=""> Show Password</span><br>

            

            <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }

            function myFunction2() {
                var x = document.getElementById("myInput2");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
        </script>
        <!-- Submit -->
        
        <input type="submit" name="submit" class="text-white bg-blue-700 hover:text-black  font-medium rounded-lg text-sm px-36 py-2.5 mb-2 mt-4" value="Continue"/>
        <br>
        <br>
        <p class="text-gray-800 text-sm mt-4 text-center">Already have an account? <a href="../loginAuth/login.php" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a></p>
    </form>
        </div>
    </div>

 </div>
</body>
</html>