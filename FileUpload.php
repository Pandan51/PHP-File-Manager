<?php
include_once("FileManager.php");


//if (isset($_POST['fileUpload'])) {
//    $file = $_FILES['myFile'];
//
//    // Define the destination directory
//    $uploadDirectory = "uploads/";
//    $targetFile = $uploadDirectory . basename($file['name']);
//
//    // Check for errors
//    if ($file['error'] === 0) {
//        // Move the file to your desired folder
//        if(!file_exists("uploads"))
//        {
//            mkdir("uploads");
//        }
//        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
//            echo "File uploaded successfully!";
//        } else {
//            echo "There was an error moving the file.";
//        }
//    } else {
//        echo "Error code: " . $file['error'];
//    }
//}

echo $_FILES["myFile"]["name"];
echo $_POST['fileUpload'];