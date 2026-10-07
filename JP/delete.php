
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include "db.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "DELETE FROM inventory WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Could not delete the record.";
    }
}

?>

