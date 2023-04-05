<?php

require('../database.php');

if (isset($_SESSION['user'])) {
    header('location: /');
    exit();
}

if(isset($_GET['redirect_to'])){
    $url_query = "?redirect_to" . $_GET['redirect_to'];
}

$errors = [];
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ((strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) && strlen($password) > 0){
        
        $query = sprintf(
            "SELECT * FROM users WHERE email = '%s'",
            mysqli_real_escape_string($conn, $email)
        );

        //dd($query);
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $errors['body'] = "Errors when select the data.";
        }else {
            $row = mysqli_fetch_assoc($result);
            
            if (!empty($row)) {
                if (password_verify($password,$row['password'])) {
                    // todo::to handel later
                    login([
                        'id' => $row['id'],
                        'email' => $email
                    ]);

                    if(isset($_GET['redirect_to'])){
                        header("location:".$_GET['redirect_to']);
                        exit();
                    }else{
                        header('location: /');
                    exit();
                    }
                    
                } else {
                    $errors['body'] = "Enter valid email and password.!!!!!";
                }
            
            } else {
                $errors['body'] = "Enter valid email and password.";
            }
        }
    } else {
        $errors['body'] = "Enter valid email and password.";
    }
}
?>

<?php require base_path("view/header.view.php")?>
<?php require base_path("view/nav.view.php")?>

<div class="container mt-3 w-50 p-3">
    <form method="POST" action="">
        <div class="mb-3">
            <label for="" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="" aria-describedby="emailHelp"
                placeholder="Eg: example@gmail.com">
            <div class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <div class="mt-3">
        <span>If you deson't have account ?</strong>
            <a href="/register" class="text-decoration-none">Sign Up</a>
    </div>

    <?php if(!empty($errors)): ?>
    <div class="text-danger">
        <?= $errors['body'] ?>
    </div>
    <?php endif ?>

</div>

<?php require base_path("view/footer.view.php")?>