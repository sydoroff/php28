<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 14.11.2018
 * Time: 20:42
 */
//=========================INIT=======================================//
require_once("./CartClass.php");
session_start();
const SES_VAL_NAME = 'cart';
$cart = $_SESSION[SES_VAL_NAME];

$products = [
    2=>['name'=>'товар 1', 'price'=>233],
    7=>['name'=>'товар 2', 'price'=>333],
    8=>['name'=>'товар 4', 'price'=>133],
    9=>['name'=>'товар 5', 'price'=>138],
    43=>['name'=>'товар 3', 'price'=>332],
];

//=========================GET=======================================//
switch ($_GET["action"]){
    case 'add':
        if (!isset($cart)) {
            $cart = new CartClass(SES_VAL_NAME);
            $cart->setDiscount('count',10,7)->setDiscount('price',1500,10);
        }
        $cart->addProduct($products[$_POST['product']],$_POST['product'],$_POST['count']);
        break;
    case 'delete':
        $cart->delProduct($_POST['product']);
        break;
}
if (strpos($_SERVER["SCRIPT_NAME"],'act.php')>0) header("Location:index.php");




