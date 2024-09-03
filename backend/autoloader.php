<?php

spl_autoload_register(function ($class) {
    // Define the base directory for the namespace prefix
    $baseDir = __DIR__ . '/pages/';

    // Replace the namespace separator with the directory separator and append with .php
    $file = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    // Debugging: print the file path being checked

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    } else {
        echo "File not found: " . $file . "<br>";
    }
});
