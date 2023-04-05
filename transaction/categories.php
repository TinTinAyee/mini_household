<?php require("../database.php")?>
<?php

$user_id = $_SESSION['user']['id'];

$errorDesc = $errorAmount = "";
$desc = $amount = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user_id = $_SESSION['user']['id'];
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $option = $_POST['option'];
    $amount = $_POST['amount'];

    if(empty($desc)){
        $errorDesc = "Please enter your description";
    }
    if(empty($amount)){
        $errorAmount = "Please enter your amount";
    }
    if(!empty($desc) && !empty($amount)){
        if($option === "income"){
            $income = $amount;
            $expense = 0;
        }else{
            $expense = $amount;
            $income = 0;  
        }

        // $amount = ($income - $expense) + $amount;
        
        
        $query = sprintf(
            "INSERT INTO household (user_id,date,description,income,expense,balance) VALUES (%d,'%s','%s','%s','%s','%s')",
            mysqli_real_escape_string($conn,$user_id),
            mysqli_real_escape_string($conn,$date),
            mysqli_real_escape_string($conn,$desc),
            mysqli_real_escape_string($conn,$income),
            mysqli_real_escape_string($conn,$expense),
            mysqli_real_escape_string($conn,$amount),
        );

        $result = mysqli_query($conn,$query);

        if($result){
            header("location:/transaction");
            exit();
        }else{
            echo "Can not found database";
        }
    }else{
            $errors['input'] = "Please input description and amount!!!";
        }
}


?>
<?php require base_path("view/header.view.php"); ?>
<?php  require base_path("view/nav.view.php"); ?>

<div class="container h-100 ">
    <div class="row justify-content-center">
        <div class="col-9 ">
            <div class="card">
                <div class="card-header ">
                    <h3 class="text-center">Add New Categories</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="">Date</label>
                            <input type="date" class="form-control" name="date" value="">
                        </div>

                        <div class="mb-3">
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description"
                                placeholder="Enter your categories" value="<?= $desc ; ?>">
                            <small class="text-danger">
                                <?php echo $errorDesc ;?>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="">Please chooses income or expense</label>
                            <select name="option" class="form-control">
                                <option value="income" name="income">Income</option>
                                <option value="expense" name="expense">Expense</option>
                            </select>
                        </div>

                        <div class=" mb-3">
                            <label for="">Enter Amount</label>
                            <input type="number" class="form-control" name="amount" placeholder="$00000"
                                value="<?= $amount ; ?>">
                            <small class="text-danger">
                                <?php echo $errorAmount ;?>
                            </small>
                        </div>

                        <div class="">
                            <button type="submit" name="submit" class="btn btn-primary form-control"
                                vlaue="Choose options">Sumbit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <?php if(!empty($errors)): ?>
<div class="text-danger">
    <?= $errors['input'] ?>
</div>
<?php endif ?> -->

<?php require base_path("view/footer.view.php"); ?>