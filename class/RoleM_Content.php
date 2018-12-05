<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 04.12.2018
 * Time: 15:05
 */

require_once ('UserInterface.php');


class RoleM_Content implements UserInterface
{
    private $edited = self::ROLE_M_CONTENT;
    use role;

    function productEdit($product,$post){
        $product['name']= htmlspecialchars($post['name']);
        $product['txt']= htmlspecialchars($post['txt']);
        return $product;
    }
}