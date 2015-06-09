<?php
require "lib/bootstrap.php";

// A list of permitted file extensions
//$allowed = array('png', 'jpg', 'gif','zip', 'docx');
$allowed = array(
    "3gp" => 1,
    "avi" => 1,
    "mpeg"=> 1,
    "mkv" => 1,
    "swf" => 1,
    "wmv" => 1,
    "mpg" => 1,
    "mov" => 1,
    "mp4" => 1,
    "flv" => 1,
    "png" => 2,
    "jpg" => 2,
    "jpeg"=> 2,
    "bmp" => 2,
    "svg" => 2,
    "gif" => 2,
    "txt" => 3,
    "doc" => 3,
    "docx"=> 3,
    "xml" => 3,
    "pdf" => 3,
    "xls" => 3,
    "xlsx"=> 3,
    "mp3" => 4,
    "wav" => 4,
    "gp5" => 4,
    "gp4" => 4,
    "gp3" => 4,
    "gpx" => 4,
    "ogg" => 4,
    "wave"=> 4,
    "m4a" => 4,
    "ac3" => 4
);

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

    $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

    /*if(!in_array(strtolower($extension), $allowed)){
        echo '{"status":"error"}';
        exit;
    }*/

    if(move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/'.translit($_FILES['upl']['name']))){
        $query = $dbh->prepare("INSERT INTO  Files (User_id, File_name, File_Size, Type_id) VALUES (?, ?, ?, ?)");
        $query->bindParam(1, $user_id);
        $query->bindParam(2, $file_name);
        $query->bindParam(3, $file_size);
        $query->bindParam(4, $type_id);
        $user_id = $auth->getUID($auth->getEmail($_COOKIE['authID']));
        $file_name = translit($_FILES['upl']['name']);
        $file_size = $_FILES['upl']['size'];
        $type_id = array_key_exists(strtolower($extension), $allowed) ? $allowed[strtolower($extension)] : 5;
        $query->execute();
        echo '{"status":"success"}';
        exit;
    }
}

echo '{"status":"error"}';
exit;

function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}