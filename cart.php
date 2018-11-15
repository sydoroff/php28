<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 14.11.2018
 * Time: 20:42
 */
//=========================INIT=======================================//
session_start();
$cart = & $_SESSION['cart'];

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
            $cart = new Cart();
            $cart->setDiscount('count',10,7);
            $cart->setDiscount('price',1500,10);
        }
        $cart->addProduct($products[$_POST['product']],$_POST['product'],$_POST['count']);
        break;
    case 'delete':
        $cart->delProduct($_POST['product']);
        break;
}

if ($_SERVER["SCRIPT_NAME"]==='/cart.php') header("Location:index.php");


//=========================Class=======================================//
class Cart
{
    private $CreateDate;
    private $Shipment = array ();
    private $discount = array();

    function  __construct()
    {
        $this->CreateDate= new DateTime( 'now',  new \DateTimeZone( 'GMT+2' ) );
    }

    function addProduct($item,$id = NULL, int $count =  1)
    {
        if(!array_key_exists($id,$this->Shipment)){
        $item['add'] = new DateTime( 'now',  new \DateTimeZone( 'GMT+2' ) );
        $item['count'] = $count;
        $item['total'] = $count*$item['price'];
        $this->Shipment[$id] = $item;}
    }

    function setDiscount($type,$total,$rate){
        $this->discount[$type]=['total'=>$total,'rate'=>$rate];
    }


    function getDiscount($type = 'rate')
    {
        $rate=0;
        $proc=0;
        if ($this->discount['price']['total']<$this->totalPrice(FALSE))
        { $rate =$this->totalPrice(FALSE)*$this->discount['price']['rate']/100;
          $proc = $this->discount['price']['rate'];
        }
        if ($this->discount['count']['total']<$this->totalCount())
            {$rate = $this->totalPrice(FALSE)*$this->discount['count']['rate']/100;
             $proc = $this->discount['count']['rate'];
            }
        if ($type=='rate') return $rate;
        else return $proc;
    }

    function totalCount(){
        $totalCount = 0;
        foreach ($this->Shipment as $item) $totalCount+=$item['count'];
        return $totalCount;
    }

    function totalPrice($discount = TRUE)
    {
        $totalCount = 0;
        $totalPrice = 0;
        $rate = 0;
        foreach ($this->Shipment as $item)
            $totalPrice+=$item['count']*$item['price'];

        if ($discount) {$rate=$this->getDiscount();}

        return ($totalPrice - $rate);
    }

    function  delProduct($id)
    {
        unset($this->Shipment[$id]);
    }

    function count()
    {
        return count($this->Shipment);
    }

    function getCreateDate()
    {
        return $this->CreateDate->format('Y-m-d H:i:s');
    }

    function fetch()
    {
        return $this->Shipment;
    }

}

