<?php

if (! function_exists('copy_folder')) {
    /**
     * Copy a file, or recursively copy a folder and its contents
     *
     * @author      Aidan Lister <aidan@php.net>
     * @version     1.0.1
     * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @return      bool     Returns TRUE on success, FALSE on failure
     */
    function copy_folder($source, $dest) { 

        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }
        
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (! is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            copy_folder("$source/$entry", "$dest/$entry");
        }

        // Clean up
        $dir->close();
        return true;
    }
}

if (! function_exists('delete_folder')) {
    /**
     * Remove an entire folder recursively
     *
     * @param string $dir The folder to remove
     * @return void
     */
    function delete_folder($dir) {

        if (! is_dir($dir)) {
            return;
        }

        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}

?>