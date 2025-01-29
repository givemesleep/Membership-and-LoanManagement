<?php 

    require_once 'cruds/config.php';

    if(isset($_GET['ngalan'])){
        $name = $_GET['ngalan'];

        if($name = 123){
            echo '<input type="text" name="name" class="form-control" value="Juan Dela Cruz">';
        }
    }

?>