<?php
    session_start();
    require 'db.php';
    $status = '';
    $total_price = 0;

    /* remove item */
    if ( isset($_POST['action']) && $_POST['action'] == 'remove' ) {
        if ( !empty($_SESSION['shoping_cart']) ) {
            foreach ($_SESSION['shoping_cart'] as $key => $value) {
                if ( $_POST['code'] == $key ) {
                    unset( $_SESSION['shoping_cart'][$key] );
                    $status = '<div style="color: green" class="status">Item removed successfully<div>';
                    break;
                }
            }
            if ( empty($_SESSION['shoping_cart']) ) {
                unset($_SESSION['shoping_cart']);   
            }
        }
    }

    /* change quantity */
    if ( isset($_POST['action']) && $_POST['action'] == 'change' ) {
        foreach ( $_SESSION['shoping_cart'] as $key => $value ) {
            if ( $key == $_POST['code'] ) {
                $_SESSION['shoping_cart'][$_POST['code']]['quantity'] = $_POST['quantity'];
                $status = '<div style="color: green" class="status">Item quantity changed successfully<div>';
                break;
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
    <!-- header -->
    <div class="header">
        <h1>Shoping Card</h1>
        <!-- shoping cart logo -->
        <a href="./cart.php" class="cart-logo">
            <img src="cart-icon.png" alt="">
            <?php
                if( !empty( $_SESSION['shoping_cart'] ) ) {
                    echo '<span>' . count($_SESSION['shoping_cart']) . '</span>';
                }
            ?>
        </a>
    </div>

    <!-- shoping cart table -->
    <?php if ( isset($_SESSION['shoping_cart']) ): ?>
    <div class="cart">
        <table>
            <tbody>
                <tr>
                    <td></td>
                    <td>Item name</td>
                    <td>Quantity</td>
                    <td>Unit price</td>
                    <td>Total</td>
                </tr>
                <!-- shoping cart items -->
                <?php foreach( $_SESSION['shoping_cart'] as $item ): ?>

                    <tr>
                        <!-- item image -->
                        <td>
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                        </td>
                        <!-- item name -->
                        <td>
                            <?php echo $item['name']; ?>
                            <form method="post" action="">
                                <input type="hidden" name="code" value="<?php echo $item['code'] ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="btn-remove">remove</button>
                            </form>
                        </td>
                        <!-- item quantity -->
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="code" value="<?php echo $item['code'] ?>">
                                <input type="hidden" name="action" value="change">
                                <select name="quantity" onchange="this.form.submit()">
                                    <option <?php if ($item['quantity'] == 1 ) echo 'selected'; ?>>1</option>
                                    <option <?php if ($item['quantity'] == 2 ) echo 'selected'; ?>>2</option>
                                    <option <?php if ($item['quantity'] == 3 ) echo 'selected'; ?>>3</option>
                                    <option <?php if ($item['quantity'] == 4 ) echo 'selected'; ?>>4</option>
                                    <option <?php if ($item['quantity'] == 5 ) echo 'selected'; ?>>5</option>
                                </select>
                            </form>
                        </td>
                        <!-- item price -->
                        <td>
                            <?php echo $item['price'] ?>
                        </td>
                        <!-- total -->
                        <td>
                            <?php echo $item['price'] * $item['quantity']; ?>
                        </td>
                    </tr>

                <?php
                    $total_price += $item['price'] * $item['quantity'];
                    endforeach;
                ?>
                <!-- Total Price -->
                <tr>
                    <td colspan="5">
                        <strong>Total Price: <?php echo $total_price ?></strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <h2>Your shoping cart is empty</h2>
    <?php endif;?>
    <div>
        <a href="./index.php">return</a>
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