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
        if ($this->isAuth()&&$act=='logout'){
            $this->logOut();
            header("Location:index.php");
        }
        elseif ($act=='login'){
            if ($this->auth($email,$passwd)) header("Location:index.php");
            else header("Location:".$_SERVER['PHP_SELF']);
        }
        else{
            $this->showLoginForm();
        }
    }

    function view()
    {
        if ($this->isAuth())
        {
            echo "<p>Привет: ".$this->getUserFill('name')." ".$this->getUserFill('surname');
            echo " <a href='".$this->getUrl()."?action=logout'>Выйти</a></p>";
        }
        else
        {
            echo "<a href='".$this->getUrl()."'>Войти</a>";
        }
    }

    function showLoginForm()
    {
        if ($this->getError()) echo"<h4>Ошибка ввода логина и пароля!!!</h4>";
        ?>
        <form action="<?=$this->getUrl()?>?action=login" method="post">
            <table>
                <tr>
                    <td>E-mail:</td><td><input type="email" name="email" value="<?=$_POST['email']?>"></td>
                </tr>
                <tr>
                    <td>Password:</td><td><input type="password" name="passwd"></td>
                </tr>
            </table>
            <div class="g-recaptcha" data-sitekey="6LcloH0UAAAAAF-hHqHAHoL16dMuzZq6yxWd6iuD"></div>
            <input type="submit" value="Войти">
        </form>
        <?
    }
}