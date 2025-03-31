<?php

/**
 * Get the todos from the sqlite database, and display them in a list.
 * You need to add a sort query parameter to the page to order by date or name.
 * If the query parameter is not set, the todos should be displayed in the order they were added.
 * If the request to the database fails, display an error message.
 * If the user wants to delete a todo, a form that sends a POST request to the deleteTodoFromDatabase.php page should be displayed on each todo elements.
 * The sort option selected must be remembered after the form submission (use a query parameter).
 * The todo title and date should be displayed in a list (date in american format).
 */
$errors = [];
$success = null;
$sort = filter_input(INPUT_GET, 'sort');
$dbs = 'sqlite:../database.db';
$user = 'root';
$pass = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $db = new PDO($dbs, $user, $pass, $options);
    if ($sort === 'name') {
        $queryGet = $db->prepare('SELECT * FROM todos ORDER BY  title');
    } elseif ($sort === 'due_date') {

        $queryGet = $db->prepare('SELECT * FROM todos ORDER BY due_date');

    } else {
        $queryGet = $db->prepare('SELECT * FROM todos ');

    }
    $queryGet->execute();
    $success = 'It works';
    $result = $queryGet->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $errors[] = 'Verify your database connection';
    $errors[] = 'Database error: '.$e->getMessage();
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of todos</title>
</head>
<body>

<h1>
    All todos
</h1>

<a href="writeTodoToDatabase.php">Ajouter une nouvelle todo</a>
<form >
    <label for="sort">
  <select name="sort">
      <option name="due_date" value="due_date" <?php if ($sort === 'due_date') {
          echo 'selected="selected" ';
      } ?>>Due date</option>
      <option name="name" value="name" <?php if ($sort === 'name') {
          echo 'selected="selected" ';
      } ?>>Name</option>
  </select></label>
    <button type="submit">Sort</button>

</form>
<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->

<?php if (count($errors) > 0) { ?>
    <?php foreach ($errors as $error) { ?>
       <p><?= $error ?></p>
    <?php } ?>
<?php }  ?>


<?php foreach ($result as $row) { ?>
    <form action="deleteTodoFromDatabase.php" method="POST">
        <li> <?= htmlspecialchars($row['title']).' '.htmlspecialchars($row['due_date']).' '?>
            <button type="submit" name = 'delete' value='<?= $row['id']?>'>Delete</button></li>
    </form>
<?php } ?>





</body>
</html>