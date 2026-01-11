<?php

class FileManager
{
    function CreateFile($filename, $mode)
    {
        fopen($filename, $mode);
    }

    /**
     * Renames file or directory
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
        rmdir($dirname);
        return true;
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