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

    /**
     * Cart constructor.
     * Запоминаем время создания корзины.
     */
    function  __construct()
    {
        $this->CreateDate= new DateTime( 'now',  new \DateTimeZone( 'GMT+2' ) );
    }

    /**
     * Добавляем в корзину
     * @param $item - array
     * @param null $id - передаем номер товара
     * @param int $count - количество товара
     */
    function addProduct($item,$id = NULL, int $count =  1)
    {
        if(!array_key_exists($id,$this->Shipment)){
            $this->Shipment[$id] = $item;
            $item['add'] = new DateTime( 'now',  new \DateTimeZone( 'GMT+2' ) );
            $item['count'] = $count;
            $item['total'] = $count*$item['price'];}
    }

    /**
     * Устанавливаем скидку
     * @param $type - скидки стринг: 'count' - начисление скидки в зависимости от количества товара
     * или 'price' -начисление скидки в зависимости от общей суммы
     * @param $total - количество на которое начисляется скидка
     * @param $rate - процент скидки, целое число (7% - 7)
     */
    function setDiscount($type,$total,$rate){
        $this->discount[$type]=['total'=>$total,'rate'=>$rate];
    }

    /**
     * Расчитываем и получаем применяемую скидку
     * @param string $type - тип вывода функции: 'rate' - сумма скидки, 'proc' - процент применяемой скидки
     * @return float|int
     */
    function getDiscount($type = 'rate')
    {
        $rate=0;
        $proc=0;
        if ($this->discount['price']['total'] < $this->totalPrice(FALSE))
        { $rate =$this->totalPrice(FALSE)*$this->discount['price']['rate']/100;
          $proc = $this->discount['price']['rate'];
        }
        if ($this->discount['count']['total'] < $this->totalCount())
            {$rate = $this->totalPrice(FALSE)*$this->discount['count']['rate']/100;
             $proc = $this->discount['count']['rate'];
            }
        if ($type=='rate') return $rate;
        else return $proc;
    }

    /**
     * Количество единиц товара в корзине
     * @return int
     */
    function totalCount(){
        $totalCount = 0;
        foreach ($this->Shipment as $item) $totalCount+=$item['count'];
        return $totalCount;
    }

    /**
     * Сумма стоимости товаров в корзине
     * @param bool $discount - применение скидки
     * @return float|int
     */
    function totalPrice($discount = TRUE)
    {
        $totalPrice = 0;
        $rate = 0;
        foreach ($this->Shipment as $item)
            $totalPrice+=$item['count']*$item['price'];

        if ($discount) {$rate=$this->getDiscount();}

        return ($totalPrice - $rate);
    }

    /**
     * Удаление единицы товара из корзины
     * @param $id - товара
     */
    function  delProduct($id)
    {
        unset($this->Shipment[$id]);
    }

    /**
     * Количество наименований товара
     * @return int
     */
    function count()
    {
        return count($this->Shipment);
    }

    /**
     * Получение даты создания корзины
     * @return string
     */
    function getCreateDate()
    {
        return $this->CreateDate->format('Y-m-d H:i:s');
    }

    /**
     * Вывод всех товаров находящихся в корзине ввиде массива
     * @return array
     */
    function fetch()
    {
        return $this->Shipment;
    }

}

