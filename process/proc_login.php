<?php 

$flag = '';

if (isset($_GET['flag'])) {
    $flag = $_GET['flag'];

    if ($flag == 1) {
        header('location: ../justlog.php?login=1');
    }
    elseif ($flag == 2) {
        header('location: ../justlog.php?login=2');
    }
}

?>