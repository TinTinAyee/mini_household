<?php 
    
    require("../database.php");
    
    if (isset($_SESSION['user'])) {
        header("location:login");
        exit();
}
    
    $errorName = $errorEmail = $errorPassword = $errorConfirmPass = "";
    
    $username = $email = $password = $confirmPass = "";
    
    $errors =[];
    // if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])){}
    
    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPass = $_POST['confirmPassword'];
        $errors =[];
        
        if(empty($_POST['username'])){
            $errorName = "Need to fill your user name !"; 
        }else{
            $username = $_POST['username'];
        }

        if(empty($_POST['email'])){
            $errorEmail = "Need to fill your email address !";
        }else{
            $email = $_POST['email'];
        }
        
        if(empty($_POST['password'])){
            $errorPassword = "Enter your password !";
        }else{
            $password = $_POST['password'];
        }

        if(empty($_POST['confirmPassword'])){
            $errorConfirmPass = "Enter your confirm password !";
            
        }else{
            $confirmPass = $_POST['confirmPassword'];
        }

    
    if((strlen($username) > 0 && (strlen($email) > 0 && filter_var($email,FILTER_VALIDATE_EMAIL)) 
    && strlen($password) > 0 && strlen($confirmPass) > 0 )){

        if($password == $confirmPass){
                $query = sprintf(
                    "SELECT * FROM users WHERE email = '%s' ",
                    mysqli_real_escape_string($conn, $email),
                );
                
                $result = mysqli_query($conn,$query);
                $row = mysqli_fetch_assoc($result);

                if(!empty($row)){
                    $errors['duplicate'] = "your email already exits.";
                }else{
                    $query = sprintf(
                    "INSERT INTO users (username,email,password) VALUES ('%s','%s','%s')",
                    mysqli_real_escape_string($conn, $username),
                    mysqli_real_escape_string($conn, $email),
                    mysqli_real_escape_string($conn, password_hash($password,PASSWORD_BCRYPT))
                );
                
                $result = mysqli_query($conn,$query);

                $_SESSION['user'] =$user;
                $_SESSION['success'] ="You are now loggin";
                header('location:/login');
                exit();
                    
                }      
                
            }else{
                echo "password does not match!";
            }
        }
    }
?>

<?php require base_path("view/header.view.php"); ?>
<?php  require base_path("view/nav.view.php"); ?>

<div class="container mt-3 w-50 p-3">
    <form method="POST" action="">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your name" value=<?= $username?>>
            <small class="text-danger">
                <?php echo $errorName ;?>
            </small>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" aria-describedby="emailHelp"
                placeholder="Eg: example@gmail.com" value=<?= $email?>>
            <small class="text-danger">
                <?php echo $errorEmail ;?>
            </small>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" value=<?= $password?>>
            <small class="text-danger">
                <?php echo $errorPassword ;?>
            </small>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Comfirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" value=<?= $confirmPass?>>
            <small class="text-danger">
                <?php echo $errorConfirmPass ;?>
            </small>
        </div>
        <button type="submit" class="btn btn-primary" name="register">Register</button>
    </form>

    <div class="mt-3">
        <span>Already Account ?</span>
        <a href="/login" class="text-decoration-none">Login</a>
    </div>

    <?php if(!empty($errors)): ?>
    <div class="text-danger">
        <?= $errors['duplicate'] ?>
    </div>
    <?php endif ?>

</div>

<?php require base_path("view/footer.view.php")?>