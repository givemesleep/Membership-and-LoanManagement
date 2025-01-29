<?php
session_start();
include 'db_connection.php'; // Include your database connection file

$backupDIR = '../dbBackUps';
$dbname = 'your_database_name'; // Replace with your database name
$server = 'your_server_name'; // Replace with your server name
$username = 'your_username'; // Replace with your username
$passwd = 'your_password'; // Replace with your password

$filename = $backupDIR . '/' . $dbname . '_backup_' . date('Y-m-d') . '.gz';
$sqlCmd = "mysqldump --opt -h $server -u $username -p$passwd $dbname | gzip > $filename";
system($sqlCmd, $return_var);

$file = $dbname . '_backup_' . date('Y-m-d') . '.sql';

$Existing = "SELECT * FROM tbdatabaseinfo WHERE filename = ? AND fdpath = ?";
$ExtData = [$file, $filename];
$Exstmt = $conn->prepare($Existing);
$Exstmt->execute($ExtData);

if ($Exstmt->rowCount() > 0) {
    $_SESSION['creErr'] = 'File is already created. Please try again tomorrow!';
    header("Location: ../admin_backoffice.php?pages=BackUp");
} else {
    $sql = "INSERT INTO tbdatabaseinfo(filename, fdpath, buDate, isCreated) VALUES (?, ?, NOW(), ?)";
    $data = [$file, $filename, 1];
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);

    if ($stmt) {
        $_SESSION['creSuc'] = 'Database Backup Created Successfully';
        header("Location: ../admin_backoffice.php?pages=BackUp");
    } else {
        $_SESSION['creErr'] = 'Database Backup Failed';
        header("Location: ../admin_backoffice.php?pages=BackUp");
    }
}
?>