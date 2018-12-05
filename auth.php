<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 28.11.2018
 * Time: 0:29
 */
session_start();
require_once ('./class/UserController.php');
$user = new UserController();
$user->response($_POST['email'],$_POST['passwd'],$_GET['action']);

