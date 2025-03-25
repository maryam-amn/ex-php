<?php
/**
 * Get the values from the GET parameters with filter_input function
 */
$errors = [];
$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$age = filter_input(INPUT_GET, 'age', FILTER_SANITIZE_NUMBER_INT);
$name = ucfirst($name);

if ($name === null) {
    array_push($errors, 'Name is required');
}
if ($name === false) {
    array_push($errors, 'The name is invalit, plese use only letters and numbers');
}
if (mb_strlen($name) < 2) {
    array_push($errors, 'Missing name');
}
if ($age === null) {
    array_push($errors, 'Missing age');
}
if ($age === false) {
    array_push($errors, 'Age is invald, plese use only numbers');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>URL query parameters</title>
</head>
<body>


<?php if (count($errors) > 0) { ?>
<h1>No query parameters found</h1>
    <p>Erreurs :</p>
    <?php foreach ($errors as $error) { ?>
  <li><?= $error ?></li>

    <?php } ?>
<?php } else { ?>

<h1> <?= $name?> is <?= $age?> years old </h1>

<?php } ?>



<!-- Display parameters here in a h1 tag -->

<!-- Display message in list element in case of missing parameters -->

</body>
</html>