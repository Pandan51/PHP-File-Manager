<?php




class PathManager
{

//    public static function getFullPath($subPath = "") {
//        return GALLERY_PATH . DIRECTORY_SEPARATOR . trim($subPath, DIRECTORY_SEPARATOR);
//    }


    //Na konci "/"
    public static function EnsureDirectorySeparator($path) {
        return rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    //Vytvoření cesty s šipečkami
    public static function CreateBreadcrumbs($receivedPath) {
        // Turns "vacation/summer" into "Home > vacation > summer"
        // This makes navigation much easier for the user
        $parts = explode(DIRECTORY_SEPARATOR, $receivedPath);

        $breadcrumb_path = implode(" > ", $parts);

        return $breadcrumb_path;
    }


}

