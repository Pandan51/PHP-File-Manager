<?php
const BASE_PATH = __DIR__;
const GALLERY_PATH = BASE_PATH . DIRECTORY_SEPARATOR . "gallery";
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

<p>Current path: <?php echo BASE_PATH ?></p>
<p>Current work path: <?php echo GALLERY_PATH ?></p>
<?php
foreach (FileManager::GetFilesOfDirectory(basename(GALLERY_PATH)) as $file) {
    echo basename($file)."<br>";
}
//echo getcwd()."<br>";
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

