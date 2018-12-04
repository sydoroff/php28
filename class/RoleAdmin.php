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
    function  productEdit($products,$cell){
        switch ($cell){
            case 'name':
                return "<input type=\"text\" name=\"name\" value=\"{$products[$cell]}\" required>";
            case 'txt':
                return "<input type=\"text\" name=\"txt\" value=\"{$products[$cell]}\">";
            case 'count':
                return "<input type=\"number\" name=\"count\" value=\"{$products[$cell]}\" required>";
            case 'price':
                return "<input type=\"text\" name=\"price\" value=\"{$products[$cell]}\" required>";
            default:
                return $products[$cell];
        }
    }
    function productEditPost($product,$post){
        return ['name' => htmlspecialchars($post['name']),
            'txt' => htmlspecialchars($post['txt']),
            'count' => htmlspecialchars($post['count']),
            'price' => htmlspecialchars($post['price'])];
    }
}