<?php
    session_start();

    if(isset($_POST['btnSignInUser'])){
        require_once('open-con.php');
        if(isset($_POST['utype'])){
        $type = ($_POST['utype']);
        $strtype = implode($type);
        $username = htmlspecialchars($_POST['txtUserName']);
        $password = htmlspecialchars($_POST['txtPassword']);

        $username = stripcslashes($username);
        $password = stripcslashes($password);

        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);

        $password = md5($password);

        if($strtype === 'Admin'){
        $strSql= "
                    SELECT name FROM tbl_user 
                    WHERE username = '$username'
                    AND password = '$password'
                ";

        if($_SESSION['rsUser'] = mysqli_query($con, $strSql)){
            if(mysqli_num_rows($_SESSION['rsUser']) > 0){
                header('location:adminpanel.php');
                $_SESSION['loguser'] = mysqli_free_result($_SESSION['rsUser']);
            }
            else{
               echo "Invalid Username/Password!";
                }
            }
            else{
                echo 'ERROR: Could not execute your request.';
            }
        }
        elseif($strtype === 'Costumer'){
            $strSql= "
                        SELECT * FROM tbl_customer
                        WHERE emailAddress = '$username'
                        AND password = '$password'
                    ";
    
                    if($rsCustomer = mysqli_query($con, $strSql)){
                        if(mysqli_num_rows($rsCustomer) > 0){
            
                            $_SESSION['log'] = 'yes';
                            header('location:index.php');
                            mysqli_free_result($rsCustomer);
                        }
                        else{
                            echo "Invalid Username/Password!";
                        }
                    }
                    else{
                        echo 'ERROR: Could not execute your request.';
                    }
            }
         require_once('close-con.php');
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
    <link rel="stylesheet" href="login.css">
    <title>Static Login</title>
</head>
<body>    
    <div class="container">
        <div class="col-10 mt-5" >
                <h1><i class="fa fa-store"></i> Learn IT Easy Online Shop</h1>
            </div>
        <hr>

         <div class="form-row">
            <div class="col form-group d-grid gap-1 col-4 m-auto">   
                <div class="card">
                    <img id="profile-img" class="profile-img-card mb-2" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
                    <form class="form-signin" method="post">
                    <select name="utype[]"  class="form-control" id="utype">
                        <option value="Admin">Admin</option>
                        <option value="Costumer">Costumer</option>
                    </select><br>
                        <input type="text" name="txtUserName" id="txtUserName" class="form-control" placeholder="User Name" required>
                        <input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="Password" required>                
                        <button name="btnSignInUser" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                    </form>
                        <a href="change-password.php" class="ForgetPwd" value="Login">Change Password?</a>
                </div>              
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>