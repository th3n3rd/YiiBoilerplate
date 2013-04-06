<?php
/*
 * Post deployment script.
 *
 * Scope:
 * - Sets permissions (mainly write permissions wherever needed)
 * - Creates some directories
 * - Flushes runtime directories
 * - Runs migrations (will not on your local machine, unless you explicitly ask it to)
 */
if ($argc < 2) {
    echo "========================================================\n";
    echo "\nUsage:\n\n";
    echo "========================================================\n";
    echo "php " . $argv[0] . "migrations\n";
    echo "\n*note* additional ones can also be added into the environments folders.\n";
    echo "\nmigrations (optional), can be any of these values: migrate, no-migrate\n";
    echo "========================================================\n";
    exit();
}

$runningOnWindows = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');

$envType = $argv[1];

$root = realpath(dirname(__FILE__)) . "/../../";

/**
 * replaces slashes by correspondent system directory separators
 *
 * @param $path
 * @return mixed
 */
function pth($path)
{
    return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
}

/**
 * returns the executable path according to OS
 *
 * @return string
 */
function getPhpPath()
{
    global $runningOnWindows;
    if ($runningOnWindows) {
        return "php";
    }
    else {
        return '/usr/bin/php';
    }
}

/**
 * runs a command
 *
 * @param $command
 */
function runCommand($command)
{
    global $runningOnWindows;
    if (!$runningOnWindows) {
        $command .= ' 2>&1';
    }
    echo "Running command:\n $command ";
    $result = array();
    exec($command, $result);
    echo "\nResult is: \n";
    foreach ($result as $row) {
        echo $row, "\n";
    }
    echo "========================================================\n";
}

/**
 * Creates a directory if it doesn't exists
 *
 * @param $path
 */
function createDirIfNotExists($path)
{
    if (!file_exists($path)) {
        printLine("Creating directory: $path");
        mkdir($path);
    }

}

/**
 * Prints a nice line of text
 *
 * @param $text
 */
function printLine($text)
{
    echo "========================================================\n";
    echo "$text \n";
    echo "========================================================\n";
}

/**
 * Remove directories recursively
 *
 * @param $path
 */
function rmDirRecursive($path)
{
    global $runningOnWindows;
    if (!file_exists($path)) {
        return;
    }

    if ($runningOnWindows) {
        runCommand("rd /S /Q " . $path);
    } else {
        runCommand("/bin/rm -rf " . $path);
    }
}

if (!$runningOnWindows) {
    $result = array();
    echo "Running as:";
    exec('/usr/bin/whoami 2>&1', $result);
    foreach ($result as $row) {
        echo $row, "\n";
    }
}

// Flush assets and create directory if not existing
rmDirRecursive(pth($root . "frontend/www/assets"));
createDirIfNotExists(pth($root . "frontend/www/assets"));
rmDirRecursive(pth($root . "backend/www/assets"));
createDirIfNotExists(pth($root . "backend/www/assets"));

// runtime
createDirIfNotExists(pth($root . "frontend/runtime"));
createDirIfNotExists(pth($root . "backend/runtime"));
createDirIfNotExists(pth($root . "console/runtime"));

// permissions
chmod(pth($root . "frontend/runtime"), 02777); // permissions with setguid
chmod(pth($root . "backend/runtime"), 02777);
chmod(pth($root . "console/runtime"), 02777);
chmod(pth($root . "frontend/www/assets"), 02777);
chmod(pth($root . "backend/www/assets"), 02777);

// applying migrations (for local machines is preferred to be done manually but...)
if (!in_array('no-migrate', $argv) || in_array('migrate', $argv)) {
    runCommand(getPhpPath() . ' \'' . $root . "yiic' migrate --interactive=0");
}

echo "Done!\n";