<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 22:14
 */

require_once ('DiscountClass.php');

class CartClass
{
    private $items = array ();
    private $discount; // Скидка
    private $ses_val;
    private $sum, $count, $length; //$sum - общая сумма, $count количество единиц товара, $length - количество наименований товара

    /**
     * Cart constructor.
     * Запоминаем время создания корзины.
     * Устанавливаем название переменной сессии
     * Создаем скидки
     * @ses_val - название переменной сессии
     */
    function  __construct($ses_val = 'cart')
    {
        $this->ses_val=$ses_val;
        $this->discount = new DiscountClass();
    }

    /**
     *    Закидываем весь класс в переменную сессии
     */
    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $_SESSION [$this->ses_val] = $this;
    }


    /**
     * Добавляем в корзину
     * @param $item - array
     * @param null $id - передаем номер товара
     * @param int $count - количество товара
     */
    function addProduct($item,$id = NULL,  $count =  1)
    {
        if(!array_key_exists($id,$this->items)){
            $item['count'] = $count;
            $item['total'] = $count*$item['price'];
            $this->items[$id] = $item;
            $this->calc();
        }
        return $this;
    }

    /**
     * Устанавливаем скидку
     * @param $type - скидки стринг: 'count' - начисление скидки в зависимости от количества товара
     * или 'price' -начисление скидки в зависимости от общей суммы
     * @param $total - количество на которое начисляется скидка
     * @param $rate - процент скидки, целое число (7% - 7)
     * @return - this
     *
     */
    function setDiscount($type,$total,$rate){
        $this->discount->setDiscount($type,$total,$rate);
        $this->discount->calc($this->count,$this->sum);
        return $this;
    }

    /**
     * Расчитываем и получаем применяемую скидку
     * @param string $type - тип вывода функции: 'rate' - сумма скидки, 'proc' - процент применяемой скидки
     * @return float|int
     */
    function getDiscount($type = 'rate')
    {
        if ($type=='rate') return $this->discount->getDiscount();
        else return $this->discount->getPercent();
    }

    /**
     * Функция пересчета атрибутов: $sum, $count, $length, $discount;
     * @return $this
     */
    protected function calc()
    {
        $sum = 0; $count = 0;
        foreach ($this->items as $item)
        {
            $sum+=$item['count']*$item['price'];
            $count+=$item['count'];
        }
        $this->sum=$sum;
        $this->count=$count;
        $this->length=count($this->items);
        $this->discount->calc($this->count,$this->sum);
        return $this;
    }

    /**
     * Сумма стоимости товаров в корзине
     * @param bool $discount - применение скидки
     * @return float|int
     */
    function getSum($discount = TRUE)
    {
        $rate = 0;
        if ($discount) {$rate=$this->getDiscount();}
        return ($this->sum - $rate);
    }

    /**
     * Удаление единицы товара из корзины
     * @param $id - товара
     * @return $this
     */
    function  delProduct($id)
    {
        unset($this->items[$id]);
        $this->calc();
        return $this;
    }

    /**
     * Вывод всех товаров находящихся в корзине ввиде массива
     * @return array
     */
    function getItems()
    {
        return $this->items;
    }
}