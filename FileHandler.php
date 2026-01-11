<?php

session_start();
if (!isset($_SESSION['current_sub_path'])) {
    $_SESSION['current_sub_path'] = "";
}
const GALLERY_PATH = __DIR__ . DIRECTORY_SEPARATOR . "gallery";

spl_autoload_register(function ($classname){
    require_once("{$classname}.php");
});

$currentSubPath = $_SESSION['current_sub_path'];
$targetBase = GALLERY_PATH . DIRECTORY_SEPARATOR . $currentSubPath;

if($_POST["action"] == "makeDirectory"){

    $folderName = !empty($_POST["nameDir"]) ? basename($_POST["nameDir"]) : "New folder";

    $finalPath = $targetBase . $folderName;

    if (!file_exists($finalPath)) {
        mkdir($finalPath, 0777, true);
    }
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
}
else if($_POST["action"] == "removeDirectory"){
    if(!empty($_POST["targetDir"])){
        $name = basename($_POST["targetDir"]);
        echo $name. "<br>";
        echo $targetBase . $name;

        if(file_exists($targetBase . $name)){
            FileManager::RemoveDirectory($targetBase . $name);
        }
    }

}
else if($_POST["action"] == "renameFile") {
    try {
        if(empty($_POST["targetDir"] || empty($_POST["newName"]))) {
            throw new Exception("Please enter a valid target directory or name");
        }
        $oldName = ($_POST["targetDir"]);
        $newName = ($_POST["newName"]);

        echo $targetBase . $oldName . "<br>";
        echo $targetBase . $newName . "<br>";
        if(!file_exists($targetBase . $oldName)){
            throw new Exception("The target directory $oldName does not exist");
        }

        FileManager::RenameFile($targetBase . $oldName, $targetBase . $newName);

    }catch (Exception $e){
        echo "Error: " . $e->getMessage();
    }

}
else if($_POST["action"] == "removeFile") {
    try {
        if(empty($_POST["targetFile"])){
            throw new Exception("Please enter a valid target file name");
        }

        unlink($_POST["targetFile"]);
    }catch (Exception $e){
        echo "Error: " . $e->getMessage();
    }

}
echo $targetBase. "<br>";

echo $currentSubPath;

//header("Location: index.php");
//exit;