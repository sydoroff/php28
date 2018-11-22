<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 14.11.2018
 * Time: 22:04
 */

require_once ('./cart.php');

?>
<form action="cart.php?action=add" method="post">
    <select name="product">
        <?php
            foreach ($products as $row => $item)
                echo "<option value=\"$row\">".$item['name']." price (".$item['price'].")</option>";
        ?>
    </select>
    Count: <input type="text" name="count" maxlength="3" value="1">
    <input type="submit" value="Add to cart">
</form>
<?

if ($cart!=NULL)
{
    include ('./list.php');
}
?>
