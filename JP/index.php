<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include "db.php";

if (isset($_POST["delete"])) {

    $id = $_POST["id"];

    $sql = "DELETE FROM inventory WHERE id = $id";

    $conn->query($sql);

    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM inventory ORDER BY id ASC";
$result = $conn->query($sql);
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
            
            <a class="btn btn-primary" href="add.php">Add Item</a> 

            <div class="card"> 
                <h2>Inventory List</h2> 

                <div class="table-responsive"> 
                    <table class="table align-middle"> 
                        <thead> 
                            <tr> 
                                <th>ID</th> 
                                <th>Item Name</th> 
                                <th>Quantity</th> 
                                <th>Price</th> 
                                <th>Actions</th> 
                            </tr> 
                        </thead> 

                        <tbody>

                        <?php while ($row = $result->fetch_assoc()){ ?>

                            <tr> 
                                <td><?php echo $row["id"]; ?></td> 
                                <td><?php echo htmlspecialchars($row["item_name"]); ?></td> 
                                <td><?php echo $row["quantity"]; ?></td> 
                                <td><?php echo number_format($row["price"], 2); ?></td> 

                                <td> 
                                    <a class="btn btn-primary btn-sm" href="add.php?edit=<?php echo $row["id"]; ?>">Edit</a> 

                                    <form method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm" onclick="return confirm('Delete this item?');">Delete</button>
                                    </form>
                                </td> 
                            </tr>

                        <?php } ?>

                        </tbody> 
                    </table> 
                </div> 
            </div> 
        </main> 
    </body> 
</html>