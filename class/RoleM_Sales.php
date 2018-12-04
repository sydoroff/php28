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
    function  productEdit($products,$cell){
        switch ($cell){
            case 'price':
                echo "<input type=\"text\" name=\"price\" value=\"{$products[$cell]}\" required>";
                break;
            default:
                echo $products[$cell];
        }
    }
    function productEditPost($product,$post){
        $product['price']= htmlspecialchars($post['price']);
        return $product;
    }
}