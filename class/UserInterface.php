<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 21:00
 */

require_once ('./trait/role.php');

interface UserInterface
{
    const NAME = 'name';
    const TXT = 'txt';
    const COUNT = 'count';
    const PRICE = 'price';
    const ROLE_ADMIN = [self::NAME,self::TXT,self::COUNT,self::PRICE];
    const ROLE_M_CONTENT = [self::NAME,self::TXT];
    const ROLE_M_SALES = [self::PRICE];
    const ROLE_M_STOCK = [self::COUNT];

    function isProductEdited($cell);
    function productEdit($product,$post);
}


