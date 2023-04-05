<?php

require("../database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $date = $_POST['date'];
    $desc = $_POST['description'];
    $option = $_POST['option'];
    $amount = $_POST['amount'];

if(!empty($desc) && !empty($amount)){
    if($option === "income"){
        $income = $amount;
        $expense = 0;
    }else{
        $income = $amount;
        $expense = 0;
    }

    $query = sprintf(
        "UPDATE household SET date = '%s', description ='%s', income = %d, expense = %d, balance = %d WHERE id = %d ",
        mysqli_real_escape_string($conn,$date),
        mysqli_real_escape_string($conn,$desc),
        mysqli_real_escape_string($conn,$income),
        mysqli_real_escape_string($conn,$expense),
        mysqli_real_escape_string($conn,$amount),
        mysqli_real_escape_string($conn,$_GET['id']),

        );

    $result = mysqli_query($conn,$query);

    if(!$result){
        die("update error!");
    }else{
        header("location:/transaction");
        exit();
    }
    }   
}
    
    $user_id = $_SESSION['user']['id'];

    if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = sprintf(
    "SELECT * FROM household WHERE id = %d",
    mysqli_real_escape_string($conn,$_GET['id']),
    );

$result = mysqli_query($conn,$query);

if(!$result){
die("error id");
}

    $row = mysqli_fetch_assoc($result);

    }else{
    echo "can not show update date";
    }

?>


<?php require base_path("view/header.view.php"); ?>
<?php require base_path("view/nav.view.php"); ?>

<?php if($_SESSION['user']['id'] === $row['user_id']):?>
<?php if($row) : ?>

<div class="container py-5 h-100 ">
    <div class="row justify-content-center">
        <div class="col-9">
            <div class="card">
                <div class="card-header ">
                    <h3 class="text-center">Update Categories</h3>
                </div>
                <div class="card-body">
                    <form action="edit?id=<?= $id ?>" method="POST">
                        <div class="mb-3">
                            <label for="">Date</label>
                            <input type="date" class="form-control" name="date" value="<?= $row['date'] ; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="">Description</label>
                            <input type="text" class="form-control" name="description" readonly="readonly"
                                placeholder="Enter your categories" value="<?= $row['description'] ; ?> ">
                        </div>

                        <div class="mb-3">
                            <label for="">Your option</label>
                            <select name="option" id="" class="form-control">
                                <?php if($row['income']) : ?>
                                <option value="<?= $row['income'] ; ?>" name=" income">Income</option>
                                <?php else :?>
                                <option value="<?= $row['expense'] ; ?>" name="expense">Expense</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class=" mb-3">
                            <label for="">Enter Amount</label>
                            <input type="number" class="form-control" name="amount" placeholder="$00000"
                                value="<?= $row['balance'] ; ?>">
                        </div>

                        <div class="">
                            <button type="submit" name="update" class="btn btn-primary form-control"
                                vlaue="Choose options">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php else : ?>
Not Found data update!
<?php endif; ?>
<?php else : ?>

<?php 
    header("location:/transaction");
    exit();
?>

<?php endif ;?>

<?php require base_path("view/footer.view.php"); ?>