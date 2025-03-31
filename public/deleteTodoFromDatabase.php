<?php

/**
 * On this page, you need to remove a todo from the sqlite database.
 * The id of the todo to delete will be passed as a POST parameter.
 * You need to handle the deletion of the todo from the database.
 * If there is an error, display an error message.
 * If the deletion is successful, redirect the user to the list of todos.
 */
$dbs = 'sqlite:../database.db';
$user = 'root';
$pass = '';
$errors = [];
$success = null;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$db = new PDO($dbs, $user, $pass, $options);
$delete_id = filter_input(INPUT_POST, 'delete', FILTER_SANITIZE_NUMBER_INT);

if (isset($_POST['delete'])) {


    try {
        $query = 'DELETE FROM todos WHERE id=:delete_id';
        $statement = $db->prepare($query);
        $queryExecute = $statement->execute([':delete_id' => $delete_id]);
        if ($query_exectute) {
            $success = 'it works ';
        } else {
            $errors[] = 'something went wrong';
        }
        header('Location: displayAllTodosFromDatabase.php');
        exit();

    } catch (PDOException $e) {
        $errors[] = '<p style="color: red">Verifiy your database connection</p>'.' '.$e->getMessage();

    }
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Todo deletion</title>
</head>
<body>

<h1>Delete a todo error</h1>

<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->

<a href="displayAllTodosFromDatabase.php">Return to todo list</a>

<?php if (count($errors) > 0) { ?>
    <?php foreach ($errors as $error) { ?>
        <p><?= $error ?></p>
    <?php } ?>
<?php }  ?>

</body>
</html>
