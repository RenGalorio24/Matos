<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
// if (isset($_SESSION['SESSION_EMAIL'])) {
//     header('location:index.php');
//     die();
// }

require 'vendor/autoload.php';
@include 'config.php';


$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_POST['order'])){
    $isproceed = true;
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['street'].', '. $_POST['barangay'].', '. $_POST['city']);
    $gcash = mysqli_real_escape_string($conn, $_POST['gcash']);
    $current_city = mysqli_real_escape_string($conn, $_POST['city']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $pid = $cart_item['pid'];
            $product_details = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $pid") or die('query failed');
            $product_item = mysqli_fetch_assoc($product_details);
            $product_quantity = $product_item['stock'];
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND gcash = '$gcash' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
            $order_quantity = $cart_item['quantity'];
             if ($product_quantity >= $order_quantity && $product_quantity != 0 && $order_quantity != 0){
    
             }
             else{
                 $isproceed = false;
             }
        }
    
    if($isproceed === true){
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].''.$cart_item['pid'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
            $pid = $cart_item['pid'];
            $details_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $pid") or die('query failed');
            $item_product = mysqli_fetch_assoc($details_product);
            $quantity_product = $item_product['stock'];
            $query_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND gcash = '$gcash' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');
            $quantity_order = $cart_item['quantity'];
            $new_product_quantity = $quantity_product - $quantity_order;
            mysqli_query($conn, "UPDATE `products` SET stock = '$new_product_quantity' WHERE id = '$pid'") or die('query failed');
        }

        

    }
        $total_products = implode(', ',$cart_products);
        $total_quantity = ($cart_item['quantity']);
        $total_pid = ($cart_item['pid']);

        $city_free_delivery = ["caloocan", "malabon", "valenzuela"];

        $current_city_lower = array_map('strtolower', $city_free_delivery);

        $current_city_new = strtolower($current_city); // Convert to lowercase

        switch ($current_city_new) {
            case "caloocan":
                $delivery_fee = 'Free Delivery';
                break;

            case "malabon":
                $delivery_fee = 'Free Delivery';
                break;

            case "valenzuela":
                $delivery_fee = 'Free Delivery';
                break;
            case "manila":
                $cart_total = $cart_total + 250;
                $delivery_fee = '250';
                break;
            case "las piñas":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "makati":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "mandaluyong":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "marikina":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "muntinlupa":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "navotas":
                $cart_total = $cart_total + 250;
                $delivery_fee = '250';
                break;
            case "parañaque ":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "pasay":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "pasig":
                $cart_total = $cart_total + 500;
                $delivery_fee = '500';
                break;
            case "quezon":
                $cart_total = $cart_total + 250;
                $delivery_fee = '250';
                break;
            case "san juan":
                $cart_total = $cart_total + 250;
                $delivery_fee = '250';
                break;
            case "san juan":
                $cart_total = $cart_total + 250;
                $delivery_fee = '250';
                break;
            case "taguig":
                $cart_total = $cart_total + 250;
                $delivery_fee = '250';
                break;

            default:
            $delivery_fee = 'Free Delivery';
        }

        


        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, gcash, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$gcash', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

            

             $mail = new PHPMailer(true);

             try {
                 //Server settings
                 $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'ajbcrisologo5@gmail.com';                     //SMTP username
                 $mail->Password   = 'gbwqbwpweaypobut';                               //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                 //Recipients
                 $mail->setFrom('ajbcrisologo5@gmail.com');
                 $mail->addAddress($email);

                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'no reply';

                $mail->Body = "Your order(s) placed successfully!<br>Products ordered: $total_products<br>Delivery Fee: $delivery_fee<br>Total Price To Pay: $cart_total pesos";
                //  $mail->Body = "Your order(s) placed successfully! Products ordered: $total_products\nDelivery Fee: $delivery_fee";

                 $mail->send();
                 echo 'Message has been sent';
             } catch (Exception $e) {
                 echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
             }


        $message[] = 'order placed successfully!';
    }else{
     $message[] = 'order failed!';
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>checkout order</h3>
    <p> <a href="home.php">home</a> / checkout </p>
</section>

<section class="display-order">
    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>    
    <p> <?php echo $fetch_cart['name'] ?> <span>(<?php echo '₱'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span> </p>
    <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>
    <div class="grand-total">grand total : <span>₱<?php echo $grand_total; ?>/-</span></div>
</section>


<section class="checkout">

    <form action="" method="POST">

        <h3>place your order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Name :</span>
                <input type="text" name="name" placeholder="enter your name" required>
            </div>
            <div class="inputBox">
                <span>Number :</span>
                <input type="number" name="number" min="0" placeholder="enter your number" required>
            </div>
            <div class="inputBox">
                <span>Email :</span>
                <input type="email" name="email" placeholder="enter your email" required>
            </div>
            <div class="inputBox">
                <span>Payment Method :</span>
                <select name="method">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="Gcash(delivery)">Gcash(delivery)</option>
                    <option value="Gcash(pick-up)">Gcash(pick-up)</option>

                </select>
            </div>
            <div class="inputBox">
                <span>Address :</span>
                <input type="text" name="street" placeholder="house no. & street Name" required>
            </div>
            <div class="inputBox">
                <span>City :</span>
                <!-- <input type="text" name="city" placeholder="e.g. manila" required> -->
                <label for="city">City: </label>
                <select id="city" name="city">
                    <option value="manila">Manila</option>
                    <option value="caloocan">Caloocan</option>
                    <option value="las piñas ">Las Piñas</option>
                    <option value="makati">Makati</option>
                    <option value="malabon">Malabon</option>
                    <option value="mandaluyong">Mandaluyong</option>
                    <option value="marikina">Marikina</option>
                    <option value="muntinlupa">Muntinlupa</option>
                    <option value="navotas">Navotas</option>
                    <option value="parañaque">Parañaque</option>
                    <option value="pasay">Pasay</option>
                    <option value="pasig">Pasig</option>
                    <option value="quezon">Quezon</option>
                    <option value="san juan">San Juan</option>
                    <option value="taguig">Taguig</option>
                    <option value="valenzuela">Valenzuela</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Barangay :</span>
                <input type="text" name="barangay" placeholder="e.g. barangay" required>
            </div>
            <div class="inputBox">
                <span>Gcash Reference No. :</span>
                <input type="number" min="0" name="gcash" placeholder="e.g. 123456">
            </div>
        </div>

        <div class="gcash">
        <img src="images/gcash.png">
        </div>


        <a href="checkout_v2.php" class="option-btn">Payment</a>
        <input type="submit" name="order" value="order now" class="btn">


    </form>


</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>