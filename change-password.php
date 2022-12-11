<?php
    if (isset($_POST['btnChangePassword'])) {
        $username = htmlspecialchars($_POST['txtUserName']);
        $password = htmlspecialchars($_POST['txtPassword']);

        require_once ('open-con.php');
        $strSql = "
                    SELECT * FROM tbl_user
                    WHERE usename = '$username'
                    AND password = '$password'
                  ";
                  if($rsUser = mysqli_query($con, $strSql)){
                    if(mysqli_num_rows($rsUser) > 0){
                        echo "Valid Username/Password!";
        
                        $id = mysqli_num_rows($rsUser);
                       
                        $changepassword = htmlspecialchars($_POST['txtChangePassword1']);
                            $strSql = "
                                        UPDATE tbl_user SET
                                            password = '$changepassword'
                                        WHERE userId =  '$id'
                                    ";
        
                            if(mysqli_query($con, $strSql)){
                                header('location:static-login.php');
                            }
                            else{
                                echo 'ERROR: Failed to Update Record!';
                            }
        
                    mysqli_free_result($rsUser);
        
                    }
                    else{
                        echo "Invalid Username/Password!";
                    }
                }
                else{
                    echo 'ERROR: Could not execute your request.';
                }
                require_once('close-con.php');
            }
        
            if(isset($_POST['btnChangePasswordCustomer'])) {
                $emailAddress = htmlspecialchars($_POST['txtemailAddress']);
                $password = htmlspecialchars($_POST['txtPassword2']);
                
        
                require_once('open-connection.php');
                $strSql= "
                            SELECT * FROM tbl_customer 
                            WHERE   emailAddress = '$emailAddress'
                            AND password = '$password'
                        ";
        
                if($rsCustomer = mysqli_query($con, $strSql)){
                    if(mysqli_num_rows($rsCustomer) > 0){
                        echo "Valid Username/Password!";
        
                        $id = mysqli_num_rows($rsCustomer);
                       
                        $changepassword = htmlspecialchars($_POST['txtChangePassword2']);
                            $strSql = "
                                        UPDATE tbl_customer SET
                                            password = '$changepassword'
                                        WHERE customerID =  '$id'
                                    ";
        
                            if(mysqli_query($con, $strSql)){
                                
                            }
                            else{
                                echo 'ERROR: Failed to Update Record!';
                            }
                        mysqli_free_result($rsCustomer);
                    }
                    else{
                        echo "Invalid Username/Password!";
                    }
                }
                else{
                    echo 'ERROR: Could not execute your request.';
                }
                 require_once('close-con.php');
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
            <title>Change Password</title>
        </head>
        <body>    
            <div class="container">
                <div class="col-10 mt-5" >
                        <h1><i class="fa fa-store"></i> Learn IT Easy Online Shop</h1>
                    </div>
                <hr>
        
                 <div class="form-row">
                    <div class="col form-group d-grid gap-1 col-4 ml-auto">   
                        <div class="card">
                            <p id="profile-name" class="profile-name-card">Admin ChangePassword</p><br>
                            <form class="form-signin" method="post">            
                                <input type="text" name="txtUserName" id="txtUserName" class="form-control" placeholder="User Name" required>
                                <input type="password" name="txtPassword1" id="txtPassword1" class="form-control" placeholder="Password" required>
                                <input type="password" name="txtChangePassword1" id="txtChangePassword1" class="form-control" placeholder="New Password" required>
                                <button name="btnChangePasswordUser" class="btn btn-lg btn-success btn-block btn-signin" type="submit">confirm</button>
                                <button class="btn btn-lg btn-danger btn-block btn-signin" type="submit">Cancel</button>
                            </form>
                        </div>              
                    </div>
                    <div class="col form-group d-grid gap-1 col-4 mr-auto">   
                        <div class="card">
                            <p id="profile-name" class="profile-name-card">Customer ChangePassword</p><br>
                            <form class="form-signin" method="post">            
                                <input type="text" name="txtemailAddress" id="txtemailAddress" class="form-control" placeholder="User Name" required>
                                <input type="password" name="txtPassword2" id="txtPassword2" class="form-control" placeholder="Password" required>
                                <input type="password" name="txtChangePassword2" id="txtChangePassword2" class="form-control" placeholder="New Password" required>
                                <button name="btnChangePasswordCustomer" class="btn btn-lg btn-success btn-block btn-signin" type="submit">confirm</button>
                                <button  class="btn btn-lg btn-danger btn-block btn-signin" type="submit">Cancel</button>
                            </form>
                        </div>              
                    </div>
                </div>
            </div>
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        </body>
        </html>