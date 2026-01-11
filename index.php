<?php

const GALLERY_PATH = __DIR__ . DIRECTORY_SEPARATOR . "gallery";
session_start();
if (!isset($_SESSION['current_sub_path'])) {
    $_SESSION['current_sub_path'] = "";
}

// --- LOGIC SECTION 2: STEP IN ---
if (isset($_GET['open'])) {
    $folder = basename($_GET['open']);
    // Append the new folder to our current string
    $_SESSION['current_sub_path'] .= DIRECTORY_SEPARATOR . $folder;
    $_SESSION['current_sub_path'] = trim($_SESSION['current_sub_path'], DIRECTORY_SEPARATOR);

    header("Location: index.php"); // Refresh to clean the URL
    exit();
}

// --- LOGIC SECTION 3: GO BACK ---
if (isset($_GET['back'])) {
    $parts = explode(DIRECTORY_SEPARATOR, $_SESSION['current_sub_path']);
    array_pop($parts);
    $_SESSION['current_sub_path'] = implode(DIRECTORY_SEPARATOR, $parts);

    header("Location: index.php"); // Refresh to clean the URL
    exit();
}

$realWorkingPath = GALLERY_PATH . (empty($_SESSION['current_sub_path']) ? "" : DIRECTORY_SEPARATOR . $_SESSION['current_sub_path']);

spl_autoload_register(function ($classname){
    require_once("{$classname}.php");
});

?>

<form action="FileUpload.php" method="POST" enctype="multipart/form-data">
    <label for="fileSelect">Select file:</label>
    <input type="file" name="myFile" id="fileSelect" accept="image/png, image/jpeg, image/gif" >
    <button type="submit" name="fileUpload">Upload</button>
</form>
<form action="FileHandler.php" method="POST">
    <input type="hidden" name="currentDir" value="<?php echo $_SESSION['current_sub_path']; ?>">
    <label for="createDirectory">Make directory in this folder</label>
    <input type="text" name="nameDir" id="createDirectory" />
    <button type="submit" name="action" value="makeDirectory">Make Dir</button>
</form>
<form action="FileHandler.php" method="POST">
    <label for="removeDirectory">Remove directory</label>
    <input type="text" name="targetDir" id="removeDirectory" required/>
    <button type="submit" name="action" value="removeDirectory">Remove Dir</button>
</form>
<form action="FileHandler.php" method="POST">
    <label for="targetFile">File or directory to rename</label>
    <input type="text" name="targetDir" id="targetFile" required/>
    <label for="fileNameInput">New name</label>
    <input type="text" name="newName" id="fileNameInput" required/>
    <button type="submit" name="action" value="renameFile">Rename Dir</button>
</form>
<form action="FileHandler.php" method="POST">
    <label for="removeFile">File to delete</label>
    <input type="text" name="targetFile" id="removeFile" required/>
    <button type="submit" name="action" value="removeFile">Delete file</button>
</form>

<!--<p>Current path: --><?php //echo BASE_PATH ?><!--</p>-->

<?php

$fullPath = GALLERY_PATH . DIRECTORY_SEPARATOR . $_SESSION['current_sub_path'];
?>
    <p>Current work path: <?php echo $fullPath ?></p> <?php

// List the files in that specific location
$items = scandir($fullPath);
//$items = FileManager::GetFilesOfDirectory($fullPath);

?>
<a href="?back">Go back<br></a> <?php
// 1. Get all directories (ignores . and .. automatically)
$directories = glob($fullPath."*", GLOB_ONLYDIR);

// 2. Get images with specific extensions
// GLOB_BRACE allows the {png,jpg,...} syntax
$images = glob($fullPath."*.{png,jpg,jpeg,gif}", GLOB_BRACE);

// Merge them if you want one single list, or loop through them separately
foreach ($directories as $dir) {
    echo "📁 <a href='?open=$dir'>$dir</a><br>";
}

foreach ($images as $img) {
    echo "🖼️ $img <br>";
}
//foreach ($items as $item) {
//    if ($item === "." || $item === "..") continue;
//
//    if (is_dir($fullPath . DIRECTORY_SEPARATOR . $item)) {
//        // This link triggers the "Step In" logic above
//        echo "📁 <a href='?open=$item'>$item</a><br>";
//    } else {
//        echo "🖼️ $item<br>";
//    }
//}

echo getcwd()."<br>";
//chdir("New directory");
?>
<?php

//echo basename(getcwd())."<br>";
//chdir("gallery");
//echo basename(getcwd())."<br>";
//chdir("..");
//echo getcwd()."<br>";
//PathManager::ChangeDirectory("gallery");
////echo is_dir(getcwd()."/workspace");
//echo getcwd();

//opendir("New directory");
//$arr = scandir("New directory");
//
//echo getcwd()."<br>";
//foreach ($arr as $item)
//{
//    echo $item."<br>";
//}

