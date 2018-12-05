<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 04.12.2018
 * Time: 14:42
 */

require_once ('UserInterface.php');


class RoleM_Sales implements UserInterface
{
    private $edited = self::ROLE_M_SALES;
    use role;

    function productEdit($product,$post){
        $product['price']= htmlspecialchars($post['price']);
        return $product;
    }
}