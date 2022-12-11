<?php
    session_start();

    require ('open-connection.php');
    $strSql= "SELECT * FROM tbl_products WHERE id = ".$_SESSION['k'];
    
    if($rsProducts = mysqli_query($con, $strSql)){
        if(mysqli_num_rows($rsProducts) > 0){
           ($recProducts = mysqli_fetch_array($rsProducts));
               mysqli_free_result($rsProducts);
               }
        else{
            echo '<tr>';
                echo '<td   No Record Found!</td>';
            echo '</tr>';
                }
    }

    else{
        echo 'ERROR: Could not execute your request.';
    }
    
    // session total amount must be reinitialize to 0 everytime this page loads so that our computations will work
    $_SESSION['totalAmount'] = 0;

    if(isset($_POST['btnUpdate'])) {
        
        // fetch all the input data and store them on variables
        // these variables will become arrays since the input types are declared as arrays
        $cartKeys = $_POST['hdnKey'];
        $cartSize = $_POST['hdnSize'];
        $cartQuantities = $_POST['txtQuantity'];

        // test if all of the array variables are set, this is just a precaution and a good programming practice        
        if(isset($cartKeys) && isset($cartSize) && isset($cartQuantities)) {
            // when we update we should consider that the value of session total quantity will change
            // with that we should reinitialize its value to 0 to prepare it for the computation below

            $_SESSION['totalQuantity'] = 0;

            foreach($cartKeys as $index => $key) {
                // $index is the index of the form array element and has nothing to do with the flow of our program except to extract the values from these arrays
                // $key is the index of the item from the arrProducts
                // we are simply performing a loop and updates the quantity of the session cartItems based on the coordinates that are dynamically produced using this loop
                $_SESSION['cartItems'][$key][$cartSize[$index]] = $cartQuantities[$index];

                // then we re compute the value of the session totalQuantity
                $_SESSION['totalQuantity'] += $cartQuantities[$index];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Learn IT Easy Online Shop | Shopping Cart</title>
</head>
<body>
    <form method="post">
        <div class="container">
            <div class="row mt-5">
                <div class="col-10">
                    <h1><i class="fa fa-store"></i> Learn IT Easy Online Shop</h1>
                </div>
                <div class="col-2 text-right">
                    <a href="cart.php" class="btn btn-primary">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="badge badge-light">
                            <?php echo (isset($_SESSION['totalQuantity']) ? $_SESSION['totalQuantity'] : "0"); ?>
                        </span>
                    </a>
                </div>            
            </div>
            <hr>

            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col-1"> </th>
                                <th scope="col-3">Product</th>
                                <th scope="col-2">Size</th>
                                <th scope="col-2">Quantity</th>
                                <th scope="col-2">Price</th>
                                <th scope="col-2">Total</th>
                                <th scope="col-1"> </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <!-- this is the part where we assemble our cart intl_get_error_message
                            we started it by testing out if the cartItems is set, meaning if the user has already purchased something
                            then we perfom a nested foreach in order to extract all the values we need from our session cartItems
                            remember that the structure of our session cartitems goes like this
                            $_SESSION['cartItems'][key][size] = quantity -->

                            <?php if(isset($_SESSION['cartItems'])): ?>
                                <?php foreach($_SESSION['cartItems'] as $key => $value): ?>
                                    <?php foreach($value as $size => $quantity): ?>

                                        <!-- this is where we recompute our sesstion totalamount value based on the price of the selected item multiplied by the number of purchased item -->
                                                                
                                        
                                        <!-- following are just print outs of values and components that should appear in the cart table -->
                                        <tr>                                        
                                            <td><img src="img/<?php echo $arrProducts[$key]['photo1']; ?>" class="img-thumbnail" style="height: 50px;"></td>
                                            <td><?php echo $recProducts['name']; ?></td>
                                            <td><?php echo $size; ?></td>
                                            <td>
                                                <!-- we need to create three input elements so that we can perform updates on the number of purchases
                                                each input elements are responsible to supply the necessary values (key, size and quantity) in order for the update to work -->
                                                <input type="hidden" name="hdnKey[]" value="<?php echo $key; ?>">
                                                <input type="hidden" name="hdnSize[]" value="<?php echo $size; ?>">
                                                <input type="number" name="txtQuantity[]" value="<?php echo $quantity; ?>" class="form-control text-center" min="1" max="100" required style="width: 150px;">
                                            </td>
                                            <td>₱ <?php echo number_format($recProducts['price'], 2); ?></td>
                                            <td>₱ <?php echo  number_format($recProducts['price'] * $quantity, 2); ?></td>
                                            <?php $_SESSION['totalAmount'] += $recProducts['price'] * $quantity; ?> 
                                            
                                            <!-- the remove link will contain also the same three get variable parameters in order for our product delition to work -->
                                            <td><a href="remove-confirm.php?<?php echo 'k=' . $key . '&s=' . $size . '&q=' . $quantity; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                                    <tr>
                                        <td colspan="2"> </td>
                                        <td><b>Total</b></td>
                                        <td><?php echo $_SESSION['totalQuantity']; ?></td>
                                        <td>----</td>
                                        <td><b>₱ <?php echo number_format($_SESSION['totalAmount'], 2); ?><b></td>
                                        <td>----</td>
                                    </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">Cart is still Empty</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>                
                </div>            
            </div>

            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                    <a href="index.php" class="btn btn-danger btn-lg btn-block"><i class="fa fa-shopping-bag"></i> <a href="index.php">Continue Shopping</a>
                </div>
                <?php if(isset($_SESSION['cartItems'])): ?>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <button type="submit" name="btnUpdate" class="btn btn-success btn-lg btn-block"><i class="fa fa-edit"></i> Update Cart</button>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                        <a href="clear.php" class="btn btn-primary btn-lg btn-block"><i class="fa fa-sign-out-alt"></i> Checkout</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>