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

    function isProductEdited($cell){
        switch ($cell){
            case 'price':
                return true;
            default: return false;
        }
    }

    function productEdit($product,$post){
        $product['price']= htmlspecialchars($post['price']);
        return $product;
    }
}