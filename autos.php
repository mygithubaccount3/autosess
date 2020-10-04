<?php
    require_once "pdo.php";

    if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
        die('Name parameter missing');
    }

    if ( isset($_POST['logout'] ) ) {
        // Redirect the browser to game.php
        header("Location: index.php");
        return;
    }

    $message = false;
    $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');
    $cars = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $cars->fetchAll(PDO::FETCH_ASSOC);

    if ( isset($_POST['add'] ) ) {
        if(isset($_POST['mileage']) && isset($_POST['mileage']) && is_numeric($_POST['mileage']) && is_numeric($_POST['year'])) {
            if(strlen($_POST['make']) > 0) {
                $stmt->execute(array(
                    ':mk' => $_POST['make'],
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'])
                );
                $message = "Record inserted";
                // Redirect the browser to game.php
                header("Location: autos.php?name=" . urlencode($_REQUEST['name']));
                return;
            } else {
                $message = "Make is required";
            }

        } else {
            $message = "Mileage and year must be numeric";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <?=$message ?>
        <form method="post">
            <p>Make:
            <input type="text" name="make" size="40"></p>
            <p>Year:
            <input type="number" name="year"></p>
            <p>Mileage:
            <input type="number" name="mileage"></p>
            <p><button type="submit" name="add">Add</button></p>
            <input type="submit" value="Logout" name="logout"/>
        </form>
        <?php
            echo "<ul>";
            foreach ( $rows as $row ) {
                echo("<li>" . htmlentities($row['year']) . ' ' . htmlentities($row['make']) . ' ' . htmlentities($row['mileage']) . "</li>");
            }
            echo "</ul>";
        ?>
    </body>
</html>
