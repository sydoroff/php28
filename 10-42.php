<form method="post">
    A=<input type="text" name="a" value="<?=$_POST['a']?>"><br/>
    N=<input tupe="text" name="n" value="<?=$_POST['n']?>"><br/>
    <input type="submit">
</form>

<?php
function vozv ($a, $n)
{
    if ($n!=ceil($n)||$n<1)
        return "Input natural number";
        if ($n > 1) {
            $n--;
            return $a * vozv($a, $n);
        } else
            return $a;

}
if (isset($_POST['a'])&&isset($_POST['n']))
{
$p_a = $_POST['a'] * 1;
$p_n = $_POST['n'] * 1;
echo  "$p_a<sup>$p_n</sup> = ".vozv($p_a,$p_n);}
?>