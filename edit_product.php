<?php
/**
 * Created by PhpStorm.
 * User: юзер
 * Date: 03.12.2018
 * Time: 22:50
 */
require_once ('./act.php');
require_once ('./class/User.php');
require_once ('./class/RoleAdmin.php');
require_once ('./class/RoleM_Content.php');
require_once ('./class/RoleM_Sales.php');
require_once ('./class/RoleM_Stock.php');

function array_get_id_add($arr,$id)
{
    if (isset($arr[$id]))
    {
        return array_get_id_add($arr,--$id);
    }
    else return $id;
}

$user = new User();

if (!$user->isAuth()||$user->getUserFill('role')==USER){
    header('Location: /');
    exit();
}

if ($user->getUserFill('role')==ADMIN) {
    $role = new RoleAdmin();
    $admin_delete = "<a href='edit_product.php?action=delete&id=".$_GET['id']."' onclick='if(!confirm(\"Do you want delete this product?\")) return false;'>Delete</a>";
    $admin_add = "<a href='edit_product.php?action=add'>Add product</a>";
}
elseif ($user->getUserFill('role')==M_SALES) $role = new RoleM_Sales();
elseif ($user->getUserFill('role')==M_CONTENT) $role = new RoleM_Content();
elseif ($user->getUserFill('role')==M_STOCK) $role = new RoleM_Stock();

switch ($_GET['action']){
    case 'delete':
        if ($user->getUserFill('role')==ADMIN){
            unset($products[$_GET['id']]);
            $products=serialize($products);
            file_put_contents('product',$products);
        }
        header('Location: /edit_product.php');
        exit;
        break;
    case 'add_push':
        if ($user->getUserFill('role')==ADMIN)
        {
            if (!is_null($_POST['name'])&&!is_null($_POST['count'])&&!is_null($_POST['price'])){
                $products[array_get_id_add($products,count($products))] = ['name' => htmlspecialchars($_POST['name']),
                    'txt' => htmlspecialchars($_POST['txt']),
                    'count' => htmlspecialchars($_POST['count']),
                    'price' => htmlspecialchars($_POST['price'])];
                $products=serialize($products);
                file_put_contents('product',$products);
            }
            header('Location: /edit_product.php');
            exit;
        }
        else
        {
            header('Location: /edit_product.php');
            exit;
        }
        break;
    case 'push':
        $products[$_GET['id']]=$role->productEditPost($products[$_GET['id']],$_POST);
        $products=serialize($products);
        file_put_contents('product',$products);
        header('Location: /edit_product.php');
        break;
    case 'edit':
        ?>
        <form action="edit_product.php?action=push&id=<?=$_GET['id']?>" method="post">
            <table>
                <tr>
                    <td>Name:</td><td><?=$role->productEdit($products[$_GET['id']],'name')?></td>
                </tr>
                <tr>
                    <td>About:</td><td><?=$role->productEdit($products[$_GET['id']],'txt')?></td>
                </tr>
                <tr>
                    <td>Count:</td><td><?=$role->productEdit($products[$_GET['id']],'count')?></td>
                </tr>
                <tr>
                    <td>Price:</td><td><?=$role->productEdit($products[$_GET['id']],'price')?></td>
                </tr>
            </table>
            <input type="submit">&nbsp;<input type="button" value="Exit" onclick="window.location='/edit_product.php';">
        </form>
        <?
        echo $admin_delete;
        break;
    case 'add':
        if ($user->getUserFill('role')==ADMIN){
        ?>
        <form action="edit_product.php?action=add_push" method="post">
            <table>
                <tr>
                    <td>Name:</td><td><input type="text" name="name" required></td>
                </tr>
                <tr>
                    <td>About:</td><td><input type="text" name="txt"></td>
                </tr>
                <tr>
                    <td>Count:</td><td><input type="number" name="count" value="1" required></td>
                </tr>
                <tr>
                    <td>Price:</td><td><input type="text" name="price" required></td>
                </tr>
            </table>
            <input type="submit">&nbsp;<input type="button" value="Exit" onclick="window.location='/edit_product.php';">
        </form>
        <?}
        else
        {
            header('Location: /edit_product.php');
            exit();
        }
        break;
    default:

        ?>
        <table border="1">
        <tr><th>id</th><th>Name</th><th>About</th><th>Count</th><th>Price</th><th>Action</th></tr>
        <?php
        foreach ($products as $row => $item)
            echo "<tr><td>$row</td>
                      <td>{$item['name']}</td>
                      <td>{$item['txt']}</td>
                      <td>{$item['count']}</td>
                      <td>{$item['price']}</td>
                      <td><a href='edit_product.php?action=edit&id=$row'>Edit</a></td></tr>";
        ?>
        </table><?
        echo $admin_add;
}
?>
<br/><br/><a href="/">Go home</a>

