<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 04.12.2018
 * Time: 11:24
 */

require_once ('UserInterface.php');


class RoleAdmin implements UserInterface
{
    private $edited = self::ROLE_ADMIN;
    use role;

    function productEdit($product,$post){
        return ['name' => htmlspecialchars($post['name']),
            'txt' => htmlspecialchars($post['txt']),
            'count' => htmlspecialchars($post['count']),
            'price' => htmlspecialchars($post['price'])];
    }
}