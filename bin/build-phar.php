<?php
$pharFile = 'zemit.phar';

// Remove the existing Phar file if it exists
if (file_exists($pharFile)) {
    unlink($pharFile);
}

// Create the Phar file
$phar = new Phar($pharFile);

// Add all files in the project directory to the Phar archive
$phar->buildFromDirectory(__DIR__);

// Set the default stub (entry point of the Phar)
$phar->setStub($phar->createDefaultStub('index.php'));

echo "Phar file created successfully: $pharFile\n";
