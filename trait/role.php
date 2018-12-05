<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 05.12.2018
 * Time: 23:06
 */

trait role {
    function isProductEdited($cell){
        return in_array($cell,$this->edited);
        }
}