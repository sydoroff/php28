<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 21:52
 */

require_once ('User.php');

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
        <script src="/js/mod_win.js"></script>
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