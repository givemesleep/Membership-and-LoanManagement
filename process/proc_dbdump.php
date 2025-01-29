<?php

use Ifsnop\Mysqldump as IMysqldump;

try {
    $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=capsys', 'root', '');
    $dump->start('../dbBackUps/capsys_backup_' . date('Y-m-d') . '.sql');
} catch (\Exception $e) {
    echo 'mysqldump-php error: ' . $e->getMessage();
}