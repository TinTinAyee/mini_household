<?php

require "../database.php";

if (!$_SESSION['user']) {
    header('location:/login?redirect_to=/transaction');
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM household ORDER BY date ASC");

if (!$result) {
    die("error found!");
} else {

}

?>

<?php require base_path("view/header.view.php");?>
<?php require base_path("view/nav.view.php");?>

<div class="container h-100 ">

    <h1>Transaction</h1>

    <div class="d-flex justify-content-between">
        <a href="/categories" class="btn btn-primary mb-3 shadow-lg rounded">+ Add New </a>
        <form method="POST" action="/overall">
            <div class="d-flex">
                <input type="date" name="date" class=" form-control" value="<?php echo date('Y-m-d'); ?>" />
                <button type="submit" name="search" class="btn btn-primary shadow-lg rounded">
                    <i class="fa-solid fa-magnifying-glass"></i></button>

            </div>
        </form>
    </div>

    <table class="table table-bordered table-lg">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Date</th>
                <th scope="col">Description</th>
                <th scope="col">Income</th>
                <th scope="col">Expense</th>
                <th scope="col">Balance</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $balance = 0;?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>

            <?php if ($_SESSION['user']['id'] === $row['user_id']): ?>

            <tr>
                <th scope="row">
                    <?=$row['id']?>
                    </td>

                <td scope="col">
                    <?php
                        $d = strtotime($row['date']);
                        echo date("Y-m-d h:i:sa", $d);
                    ?>
                </td>
                <td scope="col"><?=$row['description']?></td>
                <td scope="col"><?=number_format($row['income'])?></td>
                <td scope="col"><?=number_format($row['expense'])?></td>
                <td scope="col">
                    <?php
                        $total = $row['income'] - $row['expense'];
                        $balance = $total + $balance;
                    ?>
                    <?=number_format($balance);?>
                </td>

                <td scope="col">
                    <a href="edit?id=<?=$row['id']?>" name="item" class=" btn btn-success shadow-lg rounded">Edit</a>

                    <a href="delete?id=<?=$row['id']?>" class="btn btn-danger shadow-lg rounded"
                        onclick="return checkdelete()">
                        Delete
                    </a>
                </td>
                <?php endif;?>
            </tr>

            <script>
            function checkdelete() {

                return confirm(" Are you sure to delete this record!")
            }
            </script>

            <?php endwhile;?>

        </tbody>
    </table>

    <!-- <div class="">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div> -->
</div>

<?php require base_path("view/footer.view.php");?>