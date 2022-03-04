<?php

function createFolder($folder){
    boolean $folderIsCreate = true;
    if(is_dir("test")){
        $forderIsCreate = false;
    }
    else{
        mkdir("test");
    }
    return $folderIsCreate;
}



?>