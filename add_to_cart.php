<?php
session_start();
include 'user/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $product_name = 'a';
    $product_price = 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1
        );
    }
}
if($conn){
        echo "Success";
    }else{
        echo "gone";
        die("Error".mysqli_connect_error());
        
    }

header("Location: index.php"); // Redirect back to the product page
?>
