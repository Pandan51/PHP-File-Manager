<?php

class FileManager
{
    function CreateFile($filename, $mode)
    {
        fopen($filename, $mode);
    }

    /**
     * Renames file or directorye
     * @param $oldName
     * @param $newName
     * @return void
     */
    public static function RenameFile($oldName, $newName)
    {
        rename($oldName, $newName);
    }

    function GetParentDir()
    {
        return dirname(__DIR__);
    }

    function MakeDirectory($dirname)
    {
        if (!empty($dirname)) {
            mkdir($dirname);
        }
    }

    public static function RemoveDirectory($dirname)
    {
        if (!file_exists($dirname)) {
            return false;
        }
        if (empty($dirname)) {
            return false;
        }
        $items = array_diff(scandir($dirname), array('.', '..'));

        if (empty($items)) {
            // 2. It's empty, just delete it
            return rmdir($dirname);
        } else {
            // 3. It has files, call your recursive function
            return self::DeleteRecursively($dirname);
        }
//        try {
//            rmdir($dirname);
//        }catch (Exception $e){
//            self::DeleteRecursively($dirname);
//        }


    }
    public static function RemoveFile($filename)
    {
        try {
            if(is_file($filename)) {
                unlink($filename);
            }
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public static function DeleteRecursively($targetDir)
    {
//        if(is_dir($targetDir))
//        {
//            FileManager::RemoveDirectory($targetDir);
//            echo "Odstraněna složka";
//        }
//        else
//        {
//            FileManager::RemoveFile($targetDir);
//            echo "Odstraněn soubor";
//        }

        if (!is_dir($targetDir))
            return false;

        // Get everything inside, excluding . and ..
        $items = array_diff(scandir($targetDir), array('.', '..'));

        foreach ($items as $item) {
            $path = $targetDir . DIRECTORY_SEPARATOR . $item;
            // If it's a directory, call this function again (Recursion)
            // If it's a file, just unlink it
            is_dir($path) ? self::DeleteRecursively($path) : unlink($path);
        }

        return rmdir($targetDir);

    }



    /**
     * Returns array of absolute path of files in the directory
     * @param $dirname
     * @return array if successful, null if error
     */
    public static function GetFilesOfDirectory($dirname)
    {
        // TODO: Implement errors
        if (!getcwd()) {
            return null;
        }

        if (!file_exists($dirname)) {
            return null;
        }


        return glob(getcwd() . "\\" . $dirname . "\*");
    }



    /**
     * Calls func GetFilesOfDirectory to get all files, then deletes them
     * @param $dirname - name of directory
     * @return void
     */
    function RemoveFilesOfDirectory($dirname)
    {
        $files = GetFilesOfDirectory($dirname);

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}