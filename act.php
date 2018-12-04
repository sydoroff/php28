<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 14.11.2018
 * Time: 20:42
 */
//=========================INIT=======================================//
require_once("./class/CartClass.php");
session_start();
const SES_VAL_NAME = 'cart';
$cart = $_SESSION[SES_VAL_NAME];

const USER = 1;
const ADMIN = 2;
const M_SALES= 3;
const M_CONTENT = 4;
const M_STOCK =5;

$products=file_get_contents('product');
$products=unserialize($products);

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




