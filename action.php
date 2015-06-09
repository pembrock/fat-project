<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 17.05.2015
 * Time: 3:35
 */
require "lib/bootstrap.php";

if (isset($_POST['signin'], $_POST['login'], $_POST['pass'])){
    $reg = $auth->login(htmlspecialchars($_POST['login']), $_POST['pass'], 1);
    if (empty($reg['error'])) {

        //setcookie('authID', $reg['hash'], time() + 60*60*24*30, '/', '.' . $_SERVER['HTTP_HOST']);
        setcookie('authID', $reg['hash']);
        echo "ok";
    }
    else
        echo $reg['message'];
    exit;
}

//Registration
if (isset($_POST['registr'], $_POST['login'], $_POST['pass'], $_POST['confirmpass'])){
    $reg = $auth->register($_POST['login'], $_POST['pass'], $_POST['confirmpass']);
    if (empty($reg['error']))
        echo "ok";
    else
        echo $reg['message'];
    exit;
}

//set view
if (isset($_POST['setView'], $_POST['view'])){
    setcookie('view', $_POST['view']);
    echo "ok";
    exit;
}

//update info

if (isset($_POST['upInfo'], $_POST['name'], $_POST['email'], $_POST['uID'])){
    $email= $_POST['email'];
    $name= $_POST['name'];
    //$uID = $auth->getUID($_COOKIE['UserEmail']);
    $uID = $_POST['uID'];
    $sql = "UPDATE users
        SET email=?, Name=?
            WHERE id=?";
    try {
        $q = $dbh->prepare($sql);
        $result = $q->execute(array($email, $name, $uID));
        //echo $uID;
        echo "ok";
        exit;
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        exit;
    }
}

//edit file info
if (isset($_POST['editFile'], $_POST['type'], $_POST['fID'])){
    $type = $_POST['type'];
    $fID = $_POST['fID'];
    $sql = "UPDATE Files
        SET Type_id=?
            WHERE ID=?";
    try {
        $q = $dbh->prepare($sql);
        $result = $q->execute(array($type, $fID));
        echo "ok";
        exit;
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
        exit;
    }
}

//save query
if (isset($_POST['saveQuery'], $_POST['url'])){
    $url = $_POST['url'];
    $uID = $auth->getUID($auth->getEmail($_COOKIE['authID']));
    $query = $dbh->prepare("INSERT INTO  Queries (User_id, Query) VALUES (?, ?)");
    $query->bindParam(1, $uID);
    $query->bindParam(2, $url);
    $query->execute();

    echo "ok";
    exit;
}