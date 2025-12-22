<?php
require "header.php";

$error = "";
$success = "";

function formatName($name) {
    return ucwords(trim($name));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function cleanSkills($string) {
    $Skills = explode(",", $string);
    $Skills = array_map("trim", $Skills);
    return implode("|", $Skills);
}

if (isset($_POST["submit"])) {
    $name = formatName($_POST["name"]);
    $email = $_POST["email"];
    $skillsInput = $_POST["skills"];

    if (empty($name) || empty($email) || empty($skillsInput)) {
        $error = "All fields are required.";
    } elseif (!validateEmail($email)) {
        $error = "Invalid email format.";
    } else {
        $skills = cleanSkills($skillsInput);
        $data = "$name,$email,$skills\n";
        file_put_contents("students.txt", $data, FILE_APPEND);
        $success = "Student saved successfully.";
    }
}
?>

<?php if ($error) echo "<p>$error</p>"; ?>
<?php if ($success) echo "<p>$success</p>"; ?>

<form method="post">
    Name:
    <input type="text" name="name"><br><br>

    Email:
    <input type="text" name="email"><br><br>

    Skills:
    <input type="text" name="skills"><br><br>

    <input type="submit" name="submit" value="Save Student">
</form>

<?php
require "footer.php";
?>
