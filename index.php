<?php

const GALLERY_PATH = __DIR__ . DIRECTORY_SEPARATOR . "gallery";
session_start();
if (!isset($_SESSION['current_sub_path'])) {
    $_SESSION['current_sub_path'] = "";
}

// Navigace hlouběji v složkách
if (isset($_GET['open'])) {
    $folder = basename($_GET['open']);
    // Append the new folder to our current string
    $_SESSION['current_sub_path'] .= DIRECTORY_SEPARATOR . $folder;
    $_SESSION['current_sub_path'] = trim($_SESSION['current_sub_path'], DIRECTORY_SEPARATOR);

    header("Location: index.php"); // Refresh to clean the URL
    exit();
}

// Navigace zpět v složkách
if (isset($_GET['back'])) {
    $parts = explode(DIRECTORY_SEPARATOR, $_SESSION['current_sub_path']);
    array_pop($parts);
    $_SESSION['current_sub_path'] = implode(DIRECTORY_SEPARATOR, $parts);

    header("Location: index.php"); // Refresh to clean the URL
    exit();
}
if(!file_exists(__DIR__. DIRECTORY_SEPARATOR. "gallery"))
{
    mkdir(__DIR__. DIRECTORY_SEPARATOR. "gallery");
}

$realWorkingPath = GALLERY_PATH . (empty($_SESSION['current_sub_path']) ? "" : DIRECTORY_SEPARATOR . $_SESSION['current_sub_path']);

spl_autoload_register(function ($classname){
    require_once(__DIR__.DIRECTORY_SEPARATOR."$classname.php");
});

?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link href="CSS/index.css" rel="stylesheet">
    </head>
    <body class="body_margin">
<h1>Tvá galerie</h1>
<form action="FileHandler.php" method="POST" enctype="multipart/form-data">
    <label for="fileSelect">Select file:</label>
    <input type="file" name="myFile" id="fileSelect" required accept="image/png, image/jpeg, image/gif" >
    <button type="submit" name="action" value="fileUpload">Upload</button>
</form>
<form action="FileHandler.php" method="POST">
    <input type="hidden" name="currentDir" value="<?php echo $_SESSION['current_sub_path']; ?>">
    <label for="createDirectory">Make directory in this folder</label>
    <input type="text" name="nameDir" id="createDirectory" />
    <button type="submit" name="action" value="makeDirectory">Make Dir</button>
</form>

<!--<form action="FileHandler.php" method="POST">-->
<!--    <label for="removeTarget">Remove file or directory</label>-->
<!--    <input type="text" name="target" id="removeTarget" required/>-->
<!--    <button type="submit" name="action" value="delete">Remove Dir</button>-->
<!--</form>-->
<!--<form action="FileHandler.php" method="POST">-->
<!--    <label for="targetFile">File or directory to rename</label>-->
<!--    <input type="text" name="targetDir" id="targetFile" required/>-->
<!--    <label for="fileNameInput">New name</label>-->
<!--    <input type="text" name="newName" id="fileNameInput" required/>-->
<!--    <button type="submit" name="action" value="renameFile">Rename Dir</button>-->
<!--</form>-->

<?php

$fullPath = PathManager::EnsureDirectorySeparator(GALLERY_PATH . DIRECTORY_SEPARATOR . $_SESSION['current_sub_path']);



?>
    <p>Current path: <?php echo PathManager::CreateBreadcrumbs($fullPath) ?></p>
    <a href="?back=1">Go back<br></a>

<div class="container">
<?php


?>
 <?php
// Všechny složky
$directories = glob($fullPath."*", GLOB_ONLYDIR);

// Všechny obrázky
// GLOB_BRACE umožňuje udělat skupinu různých výrazů
$images = glob($fullPath."*.{png,jpg,jpeg,gif}", GLOB_BRACE);


//Výpis všech složek
foreach ($directories as $dir) {

$name = basename($dir);
?>
    <div class="gallery-item">
        <a href='?open=<?php echo urlencode($name); ?>'>📁 <?php echo $name; ?></a>

        <form action="FileHandler.php" method="POST" style="display:inline;">
            <input type="hidden" name="target" value="<?php echo $name; ?>">
            <button type="submit" name="action" value="delete"
                    onclick="return confirm('Smazat složku <?php echo $name; ?>?')">🗑️</button>
        </form>

        <button onclick="renameItem('<?php echo $name; ?>')">✏️</button>
    </div>
<?php

}

// Výpis všech obrázků
foreach ($images as $img) {
    $fileName = basename($img);
    $src = "gallery/" . $_SESSION['current_sub_path'] . "/" . $fileName;
    $src = str_replace("//", "/", $src);


    ?>
    <div class="gallery-img-container">
<!--        <a href='?open=--><?php //echo urlencode($name); ?><!--'>📁 --><?php //echo $name; ?><!--</a>-->
        <p> <?php echo "$fileName" ?></p>
        <img src='<?php echo $src ?>' width='200' alt='$src'><br>

    <form action="FileHandler.php" method="POST" style="display:inline;">
        <input type="hidden" name="target" value="<?php echo $fileName; ?>">
        <button type="submit" name="action" value="delete"
                onclick="return confirm('Smazat složku <?php echo $fileName; ?>?')">🗑️</button>
    </form>

    <button onclick="renameItem('<?php echo $fileName; ?>')">✏️</button>
</div>
<?php
}
if(empty($directories) && empty($images))
{
    ?><p>Složka je prázdná..</p><?php
}

?>
    </body>
    </html>

<!--JavaScript tvořen přes AI, pro tlačítka vedle složek a obrázků-->
<script>
    function renameItem(oldName) {
        let newName = prompt("Zadejte nový název pro: " + oldName, oldName);

        if (newName && newName !== oldName) {
            // Create a temporary form to send the POST request
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'FileHandler.php';

            const params = {
                action: 'renameFile',
                targetDir: oldName, // Your handler uses 'targetDir' for the old name
                newName: newName
            };

            for (const key in params) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = params[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
<?php




