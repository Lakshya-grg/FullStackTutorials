<?php
require "header.php";

$error = "";
$success = "";

function uploadPortfolioFile($file) {
    if (!isset($file) || $file["error"] !== 0) {
        throw new Exception("File upload error.");
    }

    $allowed = ["pdf", "jpg", "jpeg", "png"];
    $maxSize = 2 * 1024 * 1024;

    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        throw new Exception("Invalid file type.");
    }

    if ($file["size"] > $maxSize) {
        throw new Exception("File too large.");
    }

    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    move_uploaded_file($file["tmp_name"], "uploads/" . basename($file["name"]));
}

if (isset($_POST["upload"])) {
    try {
        uploadPortfolioFile($_FILES["portfolio"]);
        $success = "File uploaded successfully.";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<?php if ($error) echo "<p>$error</p>"; ?>
<?php if ($success) echo "<p>$success</p>"; ?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="portfolio"><br><br>
    <input type="submit" name="upload" value="Upload File">
</form>

<?php
require "footer.php";
?>
