<?php

session_start();
if (!isset($_SESSION['current_sub_path'])) {
    $_SESSION['current_sub_path'] = "";
}

spl_autoload_register(function ($classname){
    require_once("{$classname}.php");
});

if($_POST["action"] == "makeDirectory"){
    $name = "";

    if(!empty($_POST["nameDir"])) {
        $name = basename(htmlspecialchars($_POST["nameDir"]));
    }
    else{
        $name = "New folder";
    }


    if(!file_exists($name)){
        mkdir($name);
    }
    else{
        $i = 1;
        while(file_exists("New folder($i)"))
        {
            $i++;
        }
        mkdir("New folder($i)");
    }
}
else if($_POST["action"] == "removeDirectory"){
    if(!empty($_POST["targetDir"])){
        $name = basename(htmlspecialchars($_POST["targetDir"]));
        if(file_exists($name)){
            FileManager::RemoveDirectory($name);
        }
    }

}
else if($_POST["action"] == "renameFile") {
    try {
        if(empty($_POST["targetDir"] || empty($_POST["newName"]))) {
            throw new Exception("Please enter a valid target directory or name");
        }
        $oldName = basename($_POST["targetDir"]);
        $newName = basename($_POST["newName"]);

        if(!file_exists($oldName)){
            throw new Exception("The target directory $oldName does not exist");
        }

        FileManager::RenameFile($oldName, $newName);

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
header("Location: index.php");
exit;