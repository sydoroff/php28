<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 21:33
 */

class User
{
    private $user;
    private $error;
    private $url;

    function __construct($url = 'auth.php')
    {
        $this->url=$url;
        if (is_array($_SESSION['user'])) $this->user=$_SESSION['user'];
    }

    function __destruct()
    {
        $_SESSION['user']=$this->user;
    }

    function logOut()
    {
        unset($this->user);
    }

    function isAuth()
    {
        if (is_array($this->user)) return TRUE;
        else return FALSE;
    }

    function auth($user,$pass)
    {
        $users = include ('users');
        if($arr=array_filter($users, function ($arr) use ($user,$pass) { return $arr['email']===$user&&$arr['password'] === $pass;} )) {
            $this->error=NULL;
            reset($arr);
            return $this->user = current($arr);
        }
        else {
            $this->error++;
            return FALSE;
        }
    }

    function getUserFill($id)
    {
        return $this->user[$id];
    }

    function getUrl()
    {
        return $this->url;
    }

    function getError()
    {
        return $this->error;
    }
}