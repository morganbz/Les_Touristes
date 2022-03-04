<?php

function createFolder($folder){
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