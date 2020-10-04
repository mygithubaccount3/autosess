<?php
    require_once "pdo.php";

    session_start();

    if ( ! isset($_SESSION['name']) ) {
        die('Not logged in');
    }

    $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');

    if ( isset($_POST['add'] ) ) {
        if(isset($_POST['mileage']) && isset($_POST['mileage']) && is_numeric($_POST['mileage']) && is_numeric($_POST['year'])) {
            if(strlen($_POST['make']) > 0) {
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
                );
                $_SESSION['success'] = "Record inserted";
                header("Location: view.php");
                return;
            } else {
                $_SESSION['error'] = "Make is required";
                header("Location: add.php");
                return;
            }

        } else {
            $_SESSION['error'] = "Mileage and year must be numeric";
            header("Location: add.php");
            return;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php
        if ( isset($_SESSION['error']) ) {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <h1>Tracking autos for <?=$_SESSION['name']?></h1>
    <form method="post">
        <p>Make:
        <input type="text" name="make" size="40"></p>
        <p>Year:
        <input type="number" name="year"></p>
        <p>Mileage:
        <input type="number" name="mileage"></p>
        <p><button type="submit" name="add">Add</button></p>
        <input type="submit" value="Cancel" name="cancel"/>
    </form>
</body>
</html>