<?php
error_reporting(0);

////####################################################
$extensions = [
    'openssl',
    'pdo',
    'mbstring',
    'tokenizer',
    'JSON',
    'cURL',
    'XML',
    'ctype',
    'dom',
    'fileinfo',
    'filter',
    'pcre',
    'hash',
    'session',
    'intl',
];

$folders = [
    '../../bootstrap/cache/',
    '../../storage/',
    '../../storage/app/',
    '../../storage/framework/',
    '../../storage/logs/',
    '../front_assets/',
    '../front_assets/css/',
    '../dash/',
    '../dash/css/',
    '../themes/default/',
    '../themes/purpose/'
];
////####################################################


function extension_check($name): bool
{
    if (!extension_loaded($name)) {
        return false;
    }
    return true;
}

function folder_permission($name): bool
{
    $perm = substr(sprintf('%o', fileperms($name)), -4);

    if ($perm >= '0755') {
        return  true;
    }
    return false;
}



function importDatabase(
    $mysql_host,
    $mysql_database,
    $mysql_user,
    $mysql_password,
    $admin_email,
    $admin_password,
    $license,
    $app_url,
    $install_type
): bool {

    // Run symlink.php
    include('../symlink.php');

    // Delete symlink.php
    unlink('../symlink.php');

    try {
        // Connect to the database
        $db = new PDO("mysql:host=$mysql_host;dbname=$mysql_database", $mysql_user, $mysql_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Import the SQL file
        $query = file_get_contents("DATABASE.sql");
        $stmt = $db->prepare($query);
        $stmt->execute();

        // Add a record to the admin table
        $hashedPassword = password_hash($admin_password, PASSWORD_DEFAULT);
        // $stmt = $db->prepare("INSERT INTO users (name, email, password, is_admin, status, admin_type, created_at, updated_at) VALUES (:name, :email, :password, :is_admin, :status, :admin_type, :created_at, :updated_at)");
        // update the user table where email is super@happ.com 
        $stmt = $db->prepare("UPDATE users SET email=:email, password=:password WHERE email='super@happ.com'");

        // $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $admin_email);
        $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();

        //update settings
        $sql = "UPDATE settings SET purchase_code='$license', install_type='$install_type',site_address='$app_url' WHERE id=1";

        // Prepare statement
        $updtstmt = $db->prepare($sql);
        // execute the query
        $updtstmt->execute();

        return true;
    } catch (PDOException $e) {
        // Handle any exceptions
        echo "Error: " . $e->getMessage();
        return false;
    }
    $db = null;
}
function recursiveChmod($path, $filePerm = 0644, $dirPerm = 0755)
{
    // Check if the path exists
    if (!file_exists($path)) {
        return (false);
    }

    // See whether this is a file
    if (is_file($path)) {
        // Chmod the file with our given filepermissions
        chmod($path, $filePerm);
        // If this is a directory...
    } elseif (is_dir($path)) {
        // Then get an array of the contents
        $foldersAndFiles = scandir($path);

        // Remove "." and ".." from the list
        $entries = array_slice($foldersAndFiles, 2);

        // Parse every result...
        foreach ($entries as $entry) {
            // And call this function again recursively, with the same permissions
            recursiveChmod($path . "/" . $entry, $filePerm, $dirPerm);
        }

        // When we are done with the contents of the directory, we chmod the directory itself
        chmod($path, $dirPerm);
    }

    // Everything seemed to work out well, return true
    return (true);
}

function home_base_url(): string
{
    $base_url = (isset($_SERVER['HTTPS']) &&
        $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    $tmpURL = dirname(__FILE__);
    $tmpURL = str_replace(chr(92), '/', $tmpURL);
    $tmpURL = str_replace($_SERVER['DOCUMENT_ROOT'], '', $tmpURL);
    $tmpURL = str_replace('install', '', $tmpURL);
    $tmpURL = str_replace('public', '', $tmpURL);
    $tmpURL = ltrim($tmpURL, '/');
    $tmpURL = rtrim($tmpURL, '/');
    $base_url .= $_SERVER['HTTP_HOST'] . '/' . $tmpURL;
    return $base_url;
}

function createTable($name, $details, $status)
{
    if ($status == '1') {
        $pr = '<i class="fa fa-check"><i>';
    } else {
        $pr = '<i class="fa fa-times text-red"><i>';
    }
    echo "<tr><td>$name</td><td>$details</td><td>$pr</td></tr>";
}

$base_url = home_base_url();

if (substr("$base_url", -1 == "/")) {
    $base_url = substr("$base_url", 0, -1);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}