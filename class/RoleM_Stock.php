<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 04.12.2018
 * Time: 15:40
 */

require_once ('UserInterface.php');


class RoleM_Stock implements UserInterface
{
    private $edited = self::ROLE_M_STOCK;
    use role;

    function productEdit($product,$post){
        $product['count']= htmlspecialchars($post['count']);
        return $product;
    }
}