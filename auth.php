<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 28.11.2018
 * Time: 0:29
 */
session_start();
require_once ('./class/UserRun.php');
$user = new UserRun();
$user->run($_POST['email'],$_POST['passwd'],$_GET['action']);

