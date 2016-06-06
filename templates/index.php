<?php

include("classes/user.php");
include("classes/helpers.php");

$x = get_or_post("x");
$y = get_or_post("y");

?>

<h1>Таблица умножения</h1>
<p>Для использования таблицы с числами большими 5, необходимо <a href="login.php">войти</a>.</p>

<form>
<p><input type="text" value="<?php echo $x; ?>" name="x"> <input type="text" value="<?php echo $y; ?>" name="y"> <input type="submit" value="Считать"></p>
</form>

<?php

if (($x > 5 || $y > 5) && !User::$autherized)
	echo "Нужна авторизация.";
else
{
	echo "<table>";

	for ($j = 1; $j <= $y; $j++)
	{
		echo "<tr>";
		for ($i = 1; $i <= $x; $i++)
			echo "<td>" . $i * $j . "</td>";
		echo "</tr>";
	}

	echo "</table>";
}

?>