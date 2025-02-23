<?php
include '../../database/Config.php';

if (isset($_GET['area'])) {
    $area = mysqli_real_escape_string($Conn, $_GET['area']);

    $sql = "SELECT delivery_point FROM location WHERE area = '$area' LIMIT 1";
    $result = mysqli_query($Conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['delivery_point']; 
    } else {
        echo "No delivery point found for the selected area.";
    }
} else {
    echo "Area not specified.";
}

mysqli_close($Conn);
?>
