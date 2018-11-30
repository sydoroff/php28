<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 27.11.2018
 * Time: 21:48
 */

abstract class User
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
        include ('array');
        if($arr=array_filter($users, function ($arr) use ($user,$pass) { return $arr['email']===$user&&$arr['password'] === $pass;} )) {
            $this->error=NULL;
            return $this->user = $arr[0];
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

class UserRun extends User
{
    function run($email,$passwd,$act)
    {
        $answer['error'] = 'Неизвесная ошибка!';
        if ($this->isAuth()&&$act=='logout'){
            $this->logOut();
            unset($answer['error']);
            $answer['txt'] = 'Заходите еще!';
        }
        elseif (!$this->isAuth()&&$act=='login'){
            if ($this->auth($email,$passwd)) {
                $answer['name'] = $this->getUserFill('name');
                unset($answer['error']);
            }
            else $answer['error']='Ошибка аутентификации!';
        }
       echo json_encode($answer);
    }

    function view()
    {
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="/mod_win.js"></script>
        <?
        if ($this->isAuth())
        {
            echo "<p>Привет: ".$this->getUserFill('name')." ".$this->getUserFill('surname');
            echo " <a href='#' onclick='user_logout(this)'>Выйти</a></p>";
        }
        else
        {
            echo "<a href='#' onclick=\"show_win();return false;\">Войти</a>";
            echo file_get_contents('form_login.skin');
        }
    }
}