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
    function  productEdit($products,$cell){
        switch ($cell){
            case 'name':
                return "<input type=\"text\" name=\"name\" value=\"{$products[$cell]}\" required>";
            case 'txt':
                return "<input type=\"text\" name=\"txt\" value=\"{$products[$cell]}\">";
            default:
                return $products[$cell];
        }
    }
    function productEditPost($product,$post){
        $product['name']= htmlspecialchars($post['name']);
        $product['txt']= htmlspecialchars($post['txt']);
        return $product;
    }
}