<?php

/**
 * On this page, you should display a form with two fields, one for the Name and one for the Age.
 * The server should respond to the form submission by displaying the same page with the name and age in a h1 "Toto is 20 years old".
 * If there is no submission or only one of the two fields, the h1 should display "Submit the form".
 * If the user have a name with more than 6 characters, the name must be displayed in red (only the name, not all h1).
 * If the user is more than 18 years old, you should display a list with one line per year of the age of the user.
 * The data submitted should remain displayed in the form after the submission.
 * (Your form should be semantically correct, use a label and name your fields)
 */
$text = filter_input(INPUT_POST, 'Name', FILTER_SANITIZE_SPECIAL_CHARS);
$text = ucfirst($text);
$ages_user = filter_input(INPUT_POST, 'Age', FILTER_SANITIZE_NUMBER_INT);

function input_valid($name, $age)
{
    if ($name && $age) {
        if (strlen($name) > 6) {
            return "<span style='color:red'>$name</span> is $age years old";
        } else {
            return "$name is $age years old";
        }
    } else {
        return 'Submit the form';
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
    <title>Form management</title>

</head>
<body>
<h1><?= input_valid($text, $ages_user)?></h1>


<!-- WRITE YOUR HTML AND PHP TEMPLATING HERE -->
<form  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="Name "> Name :</label>
    <input type="text" name="Name" id="Name " value="<?php echo $text; ?>" >

    <label for="Age "> Age :</label>
    <input type="text" name="Age" id="Age " value="<?php echo $ages_user; ?>">
    <button type="submit" name="Submit the form'">Submit  </button>
</form>

<ul>
    <?php if ($ages_user > 18) { ?>

        <?php for ($i = 1; $i <= $ages_user; $i++) { ?>

            <li><?= $i ?></li>

        <?php } ?>
    <?php }?>
</ul>




</body>
</html>