<?php

if (! function_exists('deleteImageFile')) {
    function deleteImageFile($banner, $path){

        // Delete File
        if(!empty($banner->image) && file_exists($path.$banner->image)){
            unlink($path.$banner->image);
        }
    }
}
