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
    function  productEdit($products,$cell){
        switch ($cell){
            case 'count':
                return "<input type=\"number\" name=\"count\" value=\"{$products[$cell]}\" required>";
            default:
                return $products[$cell];
        }
    }
    function productEditPost($product,$post){
        $product['count']= htmlspecialchars($post['count']);
        return $product;
    }
}