<?php

session_start();

include('includes/header.php');

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $product_id => $product) {
        echo "Product: {$product['name']}, Quantity: {$product['quantity']}, Price: {$product['price']}<br>";
    }
} else {
    echo "Your cart is empty.";
}



    include('includes/footer.php')
?>

