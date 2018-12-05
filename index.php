<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 14.11.2018
 * Time: 22:04
 */

require_once ('./act.php');
require_once ('./class/UserController.php');

?>
<html>
<head>

</head>
<body>
<form action="act.php?action=add" method="post">
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
echo "<br/>";
$user = new UserController();
echo $user->view();

?>
<br/><br/><a href="edit_product.php">Edit catalog</a>

</body>
</html>