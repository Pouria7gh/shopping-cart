<?php
    require_once 'db.php';
    session_start();
    $products = mysqli_query($con,'SELECT * FROM `products`');
    $status = '';

    /* Add a product to card */
    if ( isset($_POST['code']) && !empty($_POST['code']) ) {

        /* Select product from database */
        $item = mysqli_query($con, "SELECT * FROM products WHERE `code` = '$_POST[code]'");
        $item = mysqli_fetch_assoc($item);

        /* Create shoping cart array */
        $cart_array = array(
            $item['code'] => array(
                'id' => $item['id'],
                'name' => $item['name'],
                'code' => $item['code'],
                'price' => $item['price'],
                'image' => $item['image'],
                'quantity' => 1
            )
        );

        /* Add product to session */
        if( empty( $_SESSION['shoping_cart']) ) {
            $_SESSION['shoping_cart'] = $cart_array;
            $status = "<div style='color: green' class='status'>Product added</div>";
        } else {
            $keys = array_keys($_SESSION['shoping_cart']);

            if ( in_array($item['code'], $keys)) {
                $status = "<div style='color: darkorange' class='status'>Product is already added!</div>";
            } else {
                $_SESSION['shoping_cart'] = array_merge($_SESSION['shoping_cart'], $cart_array);
                $status = "<div style='color: green' class='status'>Product added</div>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Shoping Card</h1>
        <!-- cart logo -->
        <a href="./cart.php" class="cart-logo">
            <img src="cart-icon.png" alt="">
            <?php
                if( !empty( $_SESSION['shoping_cart'] ) ) {
                    echo '<span>' . count($_SESSION['shoping_cart']) . '</span>';
                }
            ?>
        </a>
    </div>
    
    <!-- show all products from db -->
    <div class="product-container">

        <?php while ( $row = mysqli_fetch_assoc($products) ): ?>
        <div class="product-card">
            <img src="<?php echo $row['image'] ?>" alt="" class="product-img">
            <span class="product-name"><?php echo $row['name'] ?></span>
            <span class="product-price"><?php echo $row['price'] ?> $</span>
            <form action="" method="post">
                <input type="submit" class="product-submit" value="Add to card">
                <input type="hidden" name="code" value="<?php echo $row['code'] ?>">
            </form>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- echo status -->
    <?php
        if ( !empty($status) ) {
            echo $status;
        }
        unset($_POST['code']);
    ?>
</body>
</html>