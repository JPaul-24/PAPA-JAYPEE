
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$id = "";
$item_name = "";
$quantity = "";
$price = "";
$edit = false;

if (isset($_GET["edit"])) {

    $id = $_GET["edit"];

    $sql = "SELECT * FROM inventory WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $item_name = $row["item_name"];
        $quantity = $row["quantity"];
        $price = $row["price"];

        $edit = true;
    }
}

if (isset($_POST["save"])) {

    $id = $_POST["id"];
    $item_name = $_POST["item_name"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    if ($id == "") {

        $sql = "INSERT INTO inventory (item_name, quantity, price)
                VALUES ('$item_name', '$quantity', '$price')";

        mysqli_query($conn, $sql);

    } else {

        $sql = "UPDATE inventory
                SET item_name='$item_name',
                    quantity='$quantity',
                    price='$price'
                WHERE id=$id";

        mysqli_query($conn, $sql);
    }

    header("Location: index.php");
    exit();
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inventory Exam</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
        <style> 
            body{background:#f3f6fa;color:#243147;font-family:Arial,sans-serif;margin:0} 
            .container{max-width:1000px;margin:auto;padding:24px} 
            .card{background:white;border:1px solid #dde4ed;border-radius:12px;padding:24px;margin-bottom:20px} 
            .form-control{display:block;box-sizing:border-box;width:100%;padding:10px;margin:8px 0 16px;border:1px solid #bbc6d3;border-radius:6px} 
            .btn{display:inline-block;padding:9px 16px;border:0;border-radius:6px;background:#1467d9;color:white;text-decoration:none;cursor:pointer} 
            .btn-danger{background:#c53644} 
            .btn-secondary{background:#66758a} 
            table{width:100%;border-collapse:collapse} 
            td,th{padding:12px;text-align:left;border-bottom:1px solid #dde4ed} 
            .alert{padding:12px;background:#fff0d6;margin:12px 0} 
            .topbar{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-bottom:20px} 
            .login{max-width:420px;margin:70px auto} 
            .muted{color:#66758a} 
            button,input{font:inherit} 
        </style> 
    </head> 
    <body> 
        <main class="container"> 

            <div class="topbar"> 
                <div> 
                    <p class="muted">PHP AND MYSQLI</p> 
                    <h1>Inventory Manager</h1> 
                </div> 

                <a class="btn btn-secondary" href="logout.php">Logout</a>
            </div> 

            <div class="card"> 

                <h2>
                    <?php echo $edit ? "Edit Item" : "Add Item"; ?>
                </h2>

                <form method="post">

                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="row"> 

                        <div class="col-md-6"> 
                            <label for="item_name">Item Name</label> 
                            <input
                                class="form-control"
                                id="item_name"
                                name="item_name"
                                value="<?php echo htmlspecialchars($item_name); ?>"
                                required
                            > 
                        </div> 

                        <div class="col-md-3"> 
                            <label for="quantity">Quantity</label> 
                            <input
                                class="form-control"
                                id="quantity"
                                name="quantity"
                                type="number"
                                value="<?php echo $quantity; ?>"
                                required
                            > 
                        </div> 

                        <div class="col-md-3"> 
                            <label for="price">Price</label> 
                            <input
                                class="form-control"
                                id="price"
                                name="price"
                                type="number"
                                value="<?php echo $price; ?>"
                                required
                            > 
                        </div> 

                    </div> 

                    <button
                        class="btn btn-primary"
                        type="submit"
                        name="save"
                    >
                        <?php echo $edit ? "Update Item" : "Add Item"; ?>
                    </button>

                    <a class="btn btn-secondary" href="index.php">
                        Clear
                    </a>

                </form> 

            </div> 

        </main> 
    </body> 
</html>

