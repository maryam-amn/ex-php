<?php

/**
 * On this page, you will create a simple form that allows user to create todos (with a name and a date).
 * The form should be submitted to this PHP page.
 * Then get the inputs from the post request with `filter_input`.
 * Then, the PHP code should verify the user inputs (minimum length, valid date...)
 * If the user input is valid, insert the new todo information in the sqlite database
 * table `todos` columns `title` and `due_date`. Then redirect the user to the list of todos.
 * If the user input is invalid, display an error to the user
 */
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$text = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$errors = [];
$success = null;


$dbs = 'sqlite:../database.db';
$user = 'root';
$pass = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
if (
    $text === ''
) {
    $errors[] = 'please enter a valid todo ';

} elseif ($date === '') {
    $errors[] = 'please enter a date';
} elseif (checkdate($date[0], $date[1], $date[2] === false)) {

    $errors[] = 'incorrect date';

} else {
    try {
        $db = new PDO($dbs, $user, $success, $options);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $text && $date) {

            $query = $db->prepare('INSERT INTO todos (title, due_date) VALUES (:title, :due_date)');
            $query->execute([
                'title' => $text,
                'due_date' => $date,
            ]);

            $success = 'It works';
            header('Location: displayAllTodosFromDatabase.php');
            exit();

        }
    } catch (PDOException $e) {
        $errors[] = 'Database error: '.$e->getMessage();
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
    <title>Create a new todo</title>
</head>
<body>

<h1>
    Create a new todo
</h1>

<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->
<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
    <label for="todo"> Todo : </label>
    <input type="text" name="name" id="todo">
    <label for="date" id="date"> date : </label>
    <input type="date" name="date" id="date">
    <button type="submit" >Submit</button>

    <?php if (count($errors) > 0) { ?>
        <?php foreach ($errors as $error) { ?>
            <p><?= $error ?></p>
        <?php } ?>
    <?php }  ?>

</form>
</body>
</html>