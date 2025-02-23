<?php 
include '../../database/Config.php';
$SuccessMessage="";
$curr_email="";
error_reporting(0);

session_start(); 
if (!isset($_SESSION['email'])) {
    header('Location: ../../loginAuth/login.php');
    exit;
}

session_start();
if($_SESSION['email']){

    $curr_email =  $_SESSION['email'];
}
$sql = "SELECT * FROM customer WHERE email='$curr_email'";
$result = mysqli_query($Conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['submit'])){
$Get_image_name = $_FILES['image']['name'];
$image_Path = "../../assets/images/".basename($Get_image_name);
$sql = "Update customer set picture='$Get_image_name' where email='$curr_email'";
if(mysqli_query($Conn, $sql) ){
move_uploaded_file($_FILES['image']['tmp_name'], $image_Path);

  $_SESSION['flash_message']="profile picture uploaded successfully.";
  if(isset($_SESSION['flash_message'])) {
      $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
  }
                                   header("Location: profile.php"); 
} else{
  $_SESSION['flash_message']="ERROR: Could not able to upload profile picture";
  if(isset($_SESSION['flash_message'])) {
      $message = $_SESSION['flash_message'];
      unset($_SESSION['flash_message']);
}
    echo '<script>window.reload()</script>';

}
header("Location: profile.php"); 
exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="shortcut icon" href="../../assets/images/stack-of-books.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">




  <div class="bg-white shadow-lg rounded-lg w-4/5 max-w-4xl p-6 flex flex-col sm:flex-row">
    <!-- Left Side: Profile Picture Upload -->
    <div class="sm:w-1/3 flex flex-col items-center">
      <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-blue-300 shadow-md">
        <img 
          id="profile-picture" 
          src="<?= isset($row['picture']) && !empty($row['picture']) ? '../../assets/images/' . $row['picture'] : 'https://via.placeholder.com/150'; ?>" 
          alt="" 
          class="w-full h-full object-cover">
      </div>
      
      <form method="POST" enctype="multipart/form-data" class="mt-4">
        <label for="file-upload" class="relative cursor-pointer group">
          <span class="inline-block px-6 py-2 bg-blue-400 hover:text-black text-white text-sm font-medium rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 transition duration-300">
            Upload Picture
          </span>
          <input 
            id="file-upload" 
            type="file" 
            name="image" 
            accept="image/*" 
            class="absolute inset-0 opacity-0 cursor-pointer">
        </label>
        <button 
          type="submit" 
          name="submit" 
          class="mt-4 bg-blue-400 text-white px-6 py-1.5 rounded-lg hover:bg-blue-600 hover:text-black transition duration-300">
          Save Picture
        </button>
      </form>
    </div>

    <!-- Right Side: User Details -->
    <div class="sm:w-2/3 sm:pl-8 mt-6 sm:mt-0">
      <h2 class="text-2xl font-semibold text-blue-600">User Profile</h2>
      <div class="mt-4">
        <p class="text-gray-700">
          <span class="font-bold">Name:</span> <?= htmlspecialchars($row['name']) ?? 'N/A'; ?>
        </p>
        <p class="text-gray-700 mt-2">
          <span class="font-bold">Email:</span> <?= htmlspecialchars($row['email']) ?? 'N/A'; ?>
        </p>
        <p class="text-gray-700 mt-2">
          <span class="font-bold">Contact No:</span> <?= htmlspecialchars($row['contact_no']) ?? 'N/A'; ?>
        </p>
        <p class="text-gray-700 mt-2">
          <span class="font-bold">Fine Amount(tk):</span> <?= htmlspecialchars($row['fine_amount']) ?? 'N/A'; ?>
        </p>
      </div>
      <a 
        href="../../loginAuth/logout.php" 
        class="mt-6 inline-block bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
        Logout
      </a>
    </div>
  </div>
</body>
</html>
