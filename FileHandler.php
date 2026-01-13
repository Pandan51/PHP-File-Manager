<?php


session_start();
if (!isset($_SESSION['current_sub_path'])) {
    $_SESSION['current_sub_path'] = "";
}
const GALLERY_PATH = __DIR__ . DIRECTORY_SEPARATOR . "gallery";

spl_autoload_register(function ($classname){
    require_once(__DIR__.DIRECTORY_SEPARATOR."$classname.php");
});

$currentSubPath = $_SESSION['current_sub_path'];
// Základní cesta
$targetBase = PathManager::EnsureDirectorySeparator(GALLERY_PATH . DIRECTORY_SEPARATOR . $currentSubPath);

switch ($_POST["action"])
{
    case "makeDirectory":

        //Název složky, nebo pokud je prázdný, je výchozí "New folder"
        $folderName = !empty($_POST["nameDir"]) ? trim(basename($_POST["nameDir"])) : "New folder";

        //Současná cesta + název složky
        $finalPath = $targetBase . $folderName;

        // Pokud existuje, vytvoř složku, jinak incrementujeme $i, dokud se nedá vytvořit
        if (!file_exists($finalPath)) {
            mkdir($finalPath);
        }
        else
        {
            $i = 1;
            while(file_exists($finalPath."($i)"))
            {
                $i++;
            }
            mkdir($finalPath."($i)");
        }


        break;
    case "delete":
        if(!empty($_POST["target"])){
            $target = ($_POST["target"]);

            // Pokud je složka, rekurzivně vyčistíme složky, pote je smažeme, dokud se nesmaže cíl
            if(is_dir($targetBase . $_POST["target"]))
            {
                FileManager::DeleteRecursively($targetBase . $target);
            }
            // jinak odstraň soubor
            else
            {
                FileManager::RemoveFile($targetBase . $target);
                echo "Odstraněn soubor";
            }
        }
        break;
    case "renameFile":

        if(empty($_POST["targetDir"]) || empty($_POST["newName"])) {
            throw new Exception("Please enter a valid target directory or name");
        }
        $oldName = basename($_POST["targetDir"]);
        $newName = trim(basename($_POST["newName"]));

//        echo $targetBase . $oldName . "<br>";
//        echo $targetBase . $newName . "<br>";
        if(!file_exists($targetBase . $oldName)){
            throw new Exception("The target directory $oldName does not exist");
        }

        FileManager::RenameFile($targetBase . $oldName, $targetBase . $newName);


        break;
    case "fileUpload":
        // Superglobální pole $_FILES
        $file = $_FILES['myFile'];

        // Define the destination directory

        $targetFile = $targetBase . basename($file['name']);

        // Check for errors
        if ($file['error'] === 0) {
            move_uploaded_file($file['tmp_name'], $targetFile);
        }
        else {
            echo "Error code: " . $file['error'];
        }
        break;
    default:
        break;
}


//if($_POST["action"] == "makeDirectory"){
//
//    $folderName = !empty($_POST["nameDir"]) ? basename($_POST["nameDir"]) : "New folder";
//
//    $finalPath = $targetBase . $folderName;
//
//    if (!file_exists($finalPath)) {
//        mkdir($finalPath);
//    }
//    if(!file_exists($name)){
//        mkdir($_SESSION['current_sub_path'] . $name);
//    }
//    else{
//        $i = 1;
//        while(file_exists("New folder($i)"))
//        {
//            $i++;
//        }
//        mkdir($_SESSION['current_sub_path'] ."New folder($i)");
//    }
//}

//else if($_POST["action"] == "removeDirectory"){
//    if(!empty($_POST["targetDir"])){
//        $name = basename($_POST["targetDir"]);
//        echo $name. "<br>";
//        echo $targetBase . $name;
//
//        if(file_exists($targetBase . $name)){
//            FileManager::RemoveDirectory($targetBase . $name);
//        }
//    }
//
//}

//else if($_POST["action"] == "renameFile") {
//    try {
//        if(empty($_POST["targetDir"] || empty($_POST["newName"]))) {
//            throw new Exception("Please enter a valid target directory or name");
//        }
//        $oldName = basename($_POST["targetDir"]);
//        $newName = basename($_POST["newName"]);
//
//        echo $targetBase . $oldName . "<br>";
//        echo $targetBase . $newName . "<br>";
//        if(!file_exists($targetBase . $oldName)){
//            throw new Exception("The target directory $oldName does not exist");
//        }
//
//        FileManager::RenameFile($targetBase . $oldName, $targetBase . $newName);
//
//    }catch (Exception $e){
//        echo "Error: " . $e->getMessage();
//    }
//
//}

//else if($_POST["action"] == "removeFile") {
//    try {
//        if(empty($_POST["targetFile"])){
//            throw new Exception("Please enter a valid target file name");
//        }
//
//        unlink($targetBase . $_POST["targetFile"]);
//    }catch (Exception $e){
//        echo "Error: " . $e->getMessage();
//    }
//
//}
//else if($_POST["action"] == "delete") {
//    if(!empty($_POST["target"])){
//        $target = trim($_POST["target"]);
//
//        if(is_dir($targetBase . $_POST["target"]))
//        {
//            FileManager::DeleteRecursively($targetBase . $target);
//        }
//        else
//        {
//
//            FileManager::RemoveFile($targetBase . $target);
//            echo "Odstraněn soubor";
//        }
//    }
//}
//else if ($_POST['action'] == "fileUpload") {
//    $file = $_FILES['myFile'];
//
//    // Define the destination directory
//
//    $targetFile = $targetBase . basename($file['name']);
//
//    // Check for errors
//    if ($file['error'] === 0) {
//        // Move the file to your desired folder
////        if(!file_exists("uploads"))
////        {
////            mkdir("uploads");
////        }
//        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
//            echo "File uploaded successfully!";
//        } else {
//            echo "There was an error moving the file.";
//        }
//    } else {
//        echo "Error code: " . $file['error'];
//    }
//}




header("Location: index.php");
exit;