<?php




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

    public static function getFullPath($subPath = "") {
        return GALLERY_PATH . DIRECTORY_SEPARATOR . trim($subPath, DIRECTORY_SEPARATOR);
    }

    public static function EnsureDirectorySeparator($path) {
        return rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    public static function CreateBreadcrumbs($receivedPath) {
        // Turns "vacation/summer" into "Home > vacation > summer"
        // This makes navigation much easier for the user
        $parts = explode(DIRECTORY_SEPARATOR, $receivedPath);

        $breadcrumb_path = implode(" > ", $parts);

        return $breadcrumb_path;
    }


}

