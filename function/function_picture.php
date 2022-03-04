<?php

function createFolder($folder){
    boolean $folderIsCreate;
    if(is_dir("test")){
        $forderIsCreate = false;
    }
    else{
        mkdir("test");
        $forderIsCreate = true;
    }
    return $folderIsCreate;
}



?>