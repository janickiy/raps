<?php

if (isset($_FILES['upload']['name'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];
    $file_name_array = explode(".", $file_name);
    $extension = end($file_name_array);
    $new_image_name = rand() . '.' . $extension;

    if ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "PNG" && $extension != "JPG" && $extension != "JPEG") {
        echo "<script type='text/javascript'>alert('Sorry, only JPG, JPEG, & PNG files are allowed. Close image properties window and try again');</script>";
    } elseif ($_FILES["upload"]["size"] > 1000000) {
        echo "<script type='text/javascript'>alert('Image is too large: Upload image under 1 MB . Close image properties window and try again');</script>";
    } else {
        move_uploaded_file($file, 'images/' . $new_image_name);

        $function_number = $_GET['CKEditorFuncNum'];
        $url = 'https://' . $_SERVER['SERVER_NAME'] . '/images/' . $new_image_name; //Set your path
        $message = '';

        $return_data = array('fileName' => $new_image_name, 'uploaded' => true, 'url' => $url);

        //echo "<script>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
          echo json_encode( $return_data );

    }
}



