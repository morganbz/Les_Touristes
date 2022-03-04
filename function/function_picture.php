<?php

function createFolder($folder){
    if(is_dir($folder)){
        $forderIsCreate = false;
    }
    else{
        mkdir($folder);
        $forderIsCreate = true;
    }
    return $folderIsCreate;
}



?>