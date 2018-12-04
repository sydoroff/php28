<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 22:16
 */

class DiscountClass
{
    private $discount = array(), $rate, $percent;

    function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->rate."";
    }

    function setDiscount($type,$total,$rate)
    {
        $this->discount[$type]=['total'=>$total,'rate'=>$rate];
        return $this;
    }

    function calc($count,$sum)
    {
        $rate=0;
        $proc=0;
        if ($this->discount['price']['total'] < $sum)
        { $rate =$sum*$this->discount['price']['rate']/100;
            $proc = $this->discount['price']['rate'];
        }
        if ($this->discount['count']['total'] < $count)
        {$rate = $sum*$this->discount['count']['rate']/100;
            $proc = $this->discount['count']['rate'];
        }
        $this->rate=$rate;
        $this->percent=$proc;
    }

    function getDiscount()
    {
        return $this->rate;
    }

    function getPercent()
    {
        return $this->percent;
    }

    function getDiscountSetups()
    {
        return $this->discount;
    }
}