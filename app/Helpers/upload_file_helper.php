<?php

function upload_single_file($anyfile)
{
    // return null if empty file
    if(!$anyfile->isValid())
    {
        return null;
    }

    // do upload if valid
    $filename = $anyfile->getRandomName();

    $target_folder_os = ROOTPATH.'public/uploads/'.date('Y').'/'.date('m');

    $target_folder_path = '/uploads/'.date('Y').'/'.date('m');
    
    $anyfile->move($target_folder_os, $filename);

    $fullpath = $target_folder_path.'/'.$filename;

    return $fullpath;
}