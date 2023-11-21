<?php 
    include('config.php');
    if (isset($_GET['script']) AND isset($_GET['version'])) {
        $script = $_GET['script'];
        $version = $_GET['version'];

        if (!empty($script) AND !empty($version)) {
            if (checkversion($version,$script)){
                echo 5;
				logs('Script : ['.$script.'] Login Success With Version : '.$version.'', 5);
            }else{
                echo 6;
				logs('Script : ['.$script.'] Login Failed With Version : '.$version.'', 6);
            }
        }
    }


?>