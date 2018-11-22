<ul>
    <?
    foreach ($cart->getItems() as $key => $item)
        echo "<li><span>
            <form method='post' action='cart.php?action=delete'>
            ".$item['name']." (".$item['price'].") Count: ".$item['count'].". subTotal: ".$item['total'].". 
            <input type='hidden' value='$key' name='product'>
            <input type='submit' value='delete' onclick='if (!confirm(\"Вы уверенны в удалении ".$item['name']."?\"))return false;'></form>
          </span></li>";

    ?>
</ul>
Rate: <?=$cart->getDiscount();?> Discaunt: <?=$cart->getDiscount('proc');?>% Total: <?=$cart->getSum();?>