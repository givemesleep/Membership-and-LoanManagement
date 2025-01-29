<?php 
session_start();
require_once '../cruds/config.php';

//Database Configuration
$server = "localhost:3036";
$dbname = "capsys";
$username = "root";
$passwd = "";

//Directory to save backup
$backupDIR = '../dbBackUps';
//Backup Name
$filename = $backupDIR . '/' .$dbname . '_backup_' . date('Y-m-d') . '.sql';
//Command To Backup Database
$sqlCmd = "mysqldump --host=$server --user=$username --password=$passwd $dbname > $filename";

exec($sqlCmd, $output, $return_var);

$file = $dbname . '_backup_' . date('Y-m-d') . '.sql';


//SQL WAYS

$Existing="SELECT * FROM tbdatabaseinfo WHERE filename = ? AND fdpath = ?";
$ExtData=array($file, $filename);
$Exstmt=$conn->prepare($Existing);
$Exstmt->execute($ExtData);

if($Exstmt->rowCount() > 0){
    $_SESSION['creErr'] = 'File is already created. Please try again tomorrow!';
    header("Location: ../admin_backoffice.php?pages=BackUp");
}else{
    $sql="INSERT INTO tbdatabaseinfo(filename, fdpath, buDate, isCreated) VALUES (?, ?, NOW(), ?)";
    $data=array($file, $filename,1);
    $stmt=$conn->prepare($sql);
    $stmt->execute($data);
    
    if($stmt){
        $_SESSION['creSuc'] = 'Database Backup Created Successfully';
        header("Location: ../admin_backoffice.php?pages=BackUp");
    }else{
        $_SESSION['creErr'] = 'Database Backup Failed';
        header("Location: ../admin_backoffice.php?pages=BackUp");
    }
}

if($return_var === 0){
    // echo "Database Backup Created Successfully ";
    
}else{
    // echo "Database Backup Failed ";
    
}

?>