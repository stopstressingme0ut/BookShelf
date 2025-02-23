<?php
include '../../database/Config.php';
$SuccessMessage = "";
$curr_email = "";
error_reporting(0);

session_start();
if ($_SESSION['email']) {
    $curr_email = $_SESSION['email'];
}
else{
    header('Location: ../../loginAuth/login.php');
}
$area="Not assigned";


$sql = "SELECT * FROM deliveryman WHERE email='$curr_email'";
// and location.location_id=deliveryman.location_id";
$result = mysqli_query($Conn, $sql);
$row = mysqli_fetch_assoc($result);

if($row['location_id'])
{
    // and location.location_id=deliveryman.location_id";
$sqlo = "SELECT * FROM deliveryman, location where location.location_id=deliveryman.location_id";
$resulto = mysqli_query($Conn, $sqlo);
$rowo = mysqli_fetch_assoc($resulto);
$area=$rowo['area'];

}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact = $_POST['mobile'];

    $sql = "UPDATE deliveryman SET name='$name', contact_no='$contact' WHERE email='$curr_email'";
    if (mysqli_query($Conn, $sql)) {
        $_SESSION['flash_message'] = "Profile updated successfully.";
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        
    } else {
        $_SESSION['flash_message'] = "ERROR: Could not update profile.";
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        echo '<script>window.reload()</script>';
    }
    header("Location: profile.php");
}

if(isset($_POST['updateProfile'])){
$Get_image_name = $_FILES['picture']['name'];
$image_Path = "../../assets/images/".basename($Get_image_name);
$sql = "Update deliveryman set picture='$Get_image_name' where email='$curr_email'";
if(mysqli_query($Conn, $sql) ){
    echo "<script>alert('hello')</script>";
move_uploaded_file($_FILES['picture']['tmp_name'], $image_Path);

  $_SESSION['flash_message']="profile picture uploaded successfully.";
  if(isset($_SESSION['flash_message'])) {
      $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
  }
} else{
  $_SESSION['flash_message']="ERROR: Could not able to upload profile picture";
  if(isset($_SESSION['flash_message'])) {
      $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
}
    echo '<script>window.reload()</script>';

}
header("Location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliveryman Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../../assets/images/stack-of-books.png" type="image/x-icon">


</head>

<body class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 text-gray-900 ml-5 mr-5">
    <div class="min-h-screen flex items-center justify-center">
        <section class="container mx-auto p-8 ml-10">
            <div class="flex flex-col lg:flex-row gap-8 items-center bg-white shadow-lg rounded-lg p-8">
                <!-- Profile Picture Section -->
                <div class="text-center">
                <div class="flex gap-1.5 justify-center pb-8 mt-5">
                <img src="../../assets/images/stack-of-books.png" class="h-8 w-8" alt="">
                <a href="../customer/index.php" class="text-2xl font-semibold text-blue-600">BookShelf</a>
            </div>
                    <div>
                        <?php
                        if ($row['picture'] != null) {
                            echo "<img src='../../assets/images/" . $row['picture'] . "' class='w-40 h-40 rounded-full border-4 border-blue-500 shadow-md mx-auto'>";
                        } else {
                            echo "<img src='../../../../images/user.jpg' class='w-40 h-40 rounded-full border-4 border-gray-300 shadow-md mx-auto'>";
                        }
                        ?>
                    </div>
                    <form method="POST" action="" enctype="multipart/form-data" class="mt-4">
                        <div class="mb-4">
                            <input type="file" name="picture" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        </div>
                        <button type="submit" name="updateProfile"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700">
                            Update Profile Picture
                        </button>
                        <div class="text-red-500 text-sm mt-2">
                            <?php echo $message; ?>
                        </div>
                    </form>
                </div>

                <!-- Profile Details Section -->
                <div class="w-full lg:w-1/2 ml-20 pr-10">
                    <h4 class="text-2xl font-bold text-gray-800 mb-6">Profile Information</h4>
                    <form id="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"
                        class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" value="<?php echo $row['name']; ?>"
                                class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" value="<?php echo $row['email']; ?>" disabled
                                class="w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 cursor-not-allowed p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                            <input type="text" name="mobile" value="<?php echo $row['contact_no']; ?>"
                                class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Area</label>
                            <input type="text" value="<?php echo $area; ?>" disabled
                                class="w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100 cursor-not-allowed p-2">
                        </div>
                        <button type="submit" name="submit"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-purple-700 w-full mt-4">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>

</html>

