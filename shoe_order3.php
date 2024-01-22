<?php
$con=mysqli_connect('localhost','root','') or
die(mysqli_error());

mysqli_select_db($con,'webb_dev') or die(mysqli_error());


//create new user data
if(isset($_POST['aadhar']))
{
    $name=$_POST['name'];
    $add=$_POST['address'];
    $adhar=$_POST['aadhar'];
    $siz=$_POST['size'];
    $b=$_POST['shoes'];
    $quan=$_POST['quantity'];  
    $phn=$_POST['phone'];
    $pric=$quan * 50;
if($name!="" && $add!="" && $adhar!="" && $siz!="" && $quan!="" && $quan<=3 && $phn!="" && $b!=""){ 
$s="INSERT INTO details VALUES('$adhar','$name','$add','$phn')";  
$t="INSERT INTO shoe_details VALUES('$adhar','$b','$siz','$quan','$pric')";
$result1=mysqli_query($con,$s) or die(mysqli_error()); 
$result2=mysqli_query($con,$t) or die(mysqli_error());
}
}  

//send user payment details
if (isset($_POST["pay"])) {
    $payOption = $_POST["pay"];
    $adhar = $_POST['aadhar'];
    $paymentMethod = "";
    if ($payOption === "online") {
        $paymentMethod = $_POST["payment_method1"];
    } elseif ($payOption === "offline") {
        $paymentMethod = $_POST["payment_method2"];
    }

    // Fixed query with missing column for the price
    $w = "INSERT INTO payment_details VALUES ('$adhar', '$payOption', '$paymentMethod')";
    $result6 = mysqli_query($con, $w) or die(mysqli_error());
}





//update customer order
if (isset($_POST['up_aad']) && isset($_POST['new_shoe'] )) {
$update_aadhar=$_POST['up_aad'];
$chng_shoe=$_POST['new_shoe'];

if($update_aadhar!="" && $chng_shoe!="")
{
    if($chng_shoe=="Jordan X" || $chng_shoe=="GOAT" || $chng_shoe=="Black Mamba" || $chng_shoe=="sewy" || $chng_shoe=="CR7" || $chng_shoe=="The Greek Freak" ){
    $u="UPDATE shoe_details SET Shoe_name='$chng_shoe' where Aadhar='$update_aadhar'";
    $result3=mysqli_query($con,$u) or die(mysqli_error());}
}
}

//delete customer order
if (isset($_POST['up_aad']) && isset($_POST['new_shoe'])){
$can_order=$_POST['can_aad'];

if($can_order!="")
{
$v1="DELETE FROM shoe_details WHERE Aadhar='$can_order'";
$v2="DELETE FROM details WHERE Aadhar='$can_order'";
$result4=mysqli_query($con,$v1);
$result5=mysqli_query($con,$v2);
}
}



//customer warranty
if (isset($_POST['aadhar2'])) {
    $addhar = $_POST['aadhar2'];
    $warr = $_POST['warranty']; 
    $x = "INSERT INTO warranty_details VALUES ('$addhar', '$warr')";
    $result7 = mysqli_query($con, $x) or die(mysqli_error());
}

//customer return info
if(isset($_POST['aadhar3'])){
    $adddhar=$_POST['aadhar3'];
    $retu=$_POST['return_shoes'];
    $emm=$_POST['email'];
    $y="INSERT INTO return_details VALUES ('$adddhar', '$retu','$emm')";
    $result8=mysqli_query($con,$y) or die(mysqli_error());
}



//admin access
//search based on aadhar number
if(isset($_POST['admin_aadhar'])) {
    $admin_aadhar = $_POST['admin_aadhar'];

    $selectQuery = "SELECT * FROM details WHERE Aadhar = '$admin_aadhar'";
    $result = mysqli_query($con, $selectQuery);

    if(mysqli_num_rows($result) > 0) {
        echo "<h2>Customer Details:</h2>";
        echo "<table border size=2>
                <tr>
                    <th>Aadhar</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                </tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$row['Aadhar']."</td>
                    <td>".$row['Name']."</td>
                    <td>".$row['Address']."</td>
                    <td>".$row['Phone']."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No customer found with the entered Aadhar number.";
    }
}

// Retrieve customer information based on shoe name
if(isset($_POST['admin_shoe'])) {
    $admin_shoe = $_POST['admin_shoe'];

    $selectQuery = "SELECT details.Aadhar, details.Name, details.Address, details.`Phone` 
                    FROM details
                    INNER JOIN shoe_details ON details.Aadhar = shoe_details.Aadhar
                    WHERE shoe_details.Shoe_name = '$admin_shoe'";
    $result = mysqli_query($con, $selectQuery);

    if(mysqli_num_rows($result) > 0) {
        echo "<h2>Customer Details for Shoe: $admin_shoe</h2>";
        echo "<table border size=2>
                <tr>
                    <th>Aadhar</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                </tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$row['Aadhar']."</td>
                    <td>".$row['Name']."</td>
                    <td>".$row['Address']."</td>
                    <td>".$row['Phone']."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No customer found for the entered shoe name: $admin_shoe.";
    }
}



//warranty yes customers
if (isset($_POST['warr_butt'])) {
    $selectQuery = "SELECT details.Aadhar, details.Name, details.Address, details.Phone
                    FROM details
                    INNER JOIN warranty_details ON details.Aadhar = warranty_details.Aadhar
                    WHERE warranty_details.Warranty = 'yes'";
    $result = mysqli_query($con, $selectQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Customer Details with Warranty:</h2>";
        echo "<table border size=2>
                <tr>
                    <th>Aadhar</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$row['Aadhar']."</td>
                    <td>".$row['Name']."</td>
                    <td>".$row['Address']."</td>
                    <td>".$row['Phone']."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No customers found with warranty.";
    }
}


//customers who returned
if (isset($_POST['return_butt'])) {
    $selectQuery = "SELECT details.Aadhar, details.Name, shoe_details.Shoe_name, shoe_details.Quantity
                    FROM details
                    INNER JOIN return_details ON details.Aadhar = return_details.Aadhar
                    INNER JOIN shoe_details ON details.Aadhar = shoe_details.Aadhar
                    WHERE return_details.Return_choice = 'yes'";
    $result = mysqli_query($con, $selectQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Customer Details with Returns:</h2>";
        echo "<table border size=2>
                <tr>
                    <th>Aadhar</th>
                    <th>Name</th>
                    <th>Shoe Name</th>
                    <th>Quantity</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$row['Aadhar']."</td>
                    <td>".$row['Name']."</td>
                    <td>".$row['Shoe_name']."</td>
                    <td>".$row['Quantity']."</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No customers found with returns.";
    }
}

mysqli_close($con);

?>

