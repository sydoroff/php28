<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 21:00
 */
interface UserInterface
{
    function isProductEdited($cell);
    function productEdit($product,$post);
}


