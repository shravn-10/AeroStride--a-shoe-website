<?php
$con = mysqli_connect('localhost', 'root', '') or die(mysqli_error());
mysqli_select_db($con, 'web_dev') or die(mysqli_error());

if (isset($_POST['aadhar'])) {
    $name = $_POST['name'];
    $add = $_POST['address'];
    $adhar = $_POST['aadhar'];
    $siz = $_POST['size'];
    $b = $_POST['shoes'];
    $quan = $_POST['quantity'];
    $phn = $_POST['phone'];
    $pric = $quan * 50;

    if (!empty($name) && !empty($add) && !empty($adhar) && !empty($siz) && !empty($quan) && !empty($phn) && !empty($b)) {
        // Insert new data into the database
        $insertDetailsQuery = "INSERT INTO details (Aadhar, Name, Address, `Phone no`) VALUES (?, ?, ?, ?)";
        $insertShoeQuery = "INSERT INTO shoe_details (Aadhar, Shoe_name, Size, Quantity, Price) VALUES (?, ?, ?, ?, ?)";

        $insertDetailsStmt = mysqli_prepare($con, $insertDetailsQuery);
        $insertShoeStmt = mysqli_prepare($con, $insertShoeQuery);

        mysqli_stmt_bind_param($insertDetailsStmt, "ssss", $adhar, $name, $add, $phn);
        mysqli_stmt_bind_param($insertShoeStmt, "sssss", $adhar, $b, $siz, $quan, $pric);

        mysqli_stmt_execute($insertDetailsStmt);
        mysqli_stmt_execute($insertShoeStmt);
        
        mysqli_stmt_close($insertDetailsStmt);
        mysqli_stmt_close($insertShoeStmt);
    }
}

if (isset($_POST['up_aad']) && isset($_POST['new_shoe'] )) {
$update_aadhar = $_POST['up_aad'];
$chng_shoe = $_POST['new_shoe'];
$can_order = $_POST['can_aad'];}

if (!empty($update_aadhar) && !empty($chng_shoe)) {
    // Update shoe name in the database
    $updateQuery = "UPDATE shoe_details SET Shoe_name = ? WHERE Aadhar = ?";
    $updateStmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "ss", $chng_shoe, $update_aadhar);
    mysqli_stmt_execute($updateStmt);
    mysqli_stmt_close($updateStmt);
}

if (!empty($can_order)) {
    // Delete records from the database
    $deleteShoeQuery = "DELETE FROM shoe_details WHERE Aadhar = ?";
    $deleteDetailsQuery = "DELETE FROM details WHERE Aadhar = ?";
    $deleteShoeStmt = mysqli_prepare($con, $deleteShoeQuery);
    $deleteDetailsStmt = mysqli_prepare($con, $deleteDetailsQuery);
    mysqli_stmt_bind_param($deleteShoeStmt, "s", $can_order);
    mysqli_stmt_bind_param($deleteDetailsStmt, "s", $can_order);
    mysqli_stmt_execute($deleteShoeStmt);
    mysqli_stmt_execute($deleteDetailsStmt);
    mysqli_stmt_close($deleteShoeStmt);
    mysqli_stmt_close($deleteDetailsStmt);
}
?>
