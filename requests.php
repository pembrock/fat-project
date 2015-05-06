<?php

if (file_exists('config.php'))
{
    $config = include('config.php');
}
else
{
    die('No config file.');
}

$mysqli = new mysqli($config['db']['host'], $config['db']['login'], $config['db']['password'], $config['db']['db']);

$r = $mysqli->query('SELECT * FROM `users`');