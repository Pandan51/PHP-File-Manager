<?php


if (empty($_SESSION['fileManager'])) {
    $_SESSION['fileManager'] = array();
}

class PathManager
{
    public static function ChangeDirectory($name)
    {
        try {
            $destination = getcwd() . "/" . $name;
            if (is_dir($destination)) {
                chdir($destination);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }


}

