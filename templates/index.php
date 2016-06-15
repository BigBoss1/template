<?php

require_once("classes/helpers.php");

global $user;

$x = intval(get_or_post("x"));
$y = intval(get_or_post("y"));

?>

<h1>Таблица умножения</h1>

<?php

if (!$user->is_auth())
	echo "<p>Для использования таблицы с числами большими 5, необходимо <a href='login.php'>войти</a>.</p>";

?>

<form>
<p><input type="text" value="<?php echo $x; ?>" name="x"> <input type="text" value="<?php echo $y; ?>" name="y">
	<input type="submit" value="Считать"></p>
</form>

<?php

if (($x > 5 || $y > 5) && !$user->is_auth())
	echo "Нужна авторизация.";
else
{
	if ($x <= 18)
	{
		echo "<table cellpadding='5px' cellspacing='2px'>";

		for ($j = 1; $j <= $y; $j++) {
			echo "<tr align='center'>";
			for ($i = 1; $i <= $x; $i++)
				echo "<td title='" . $i . " * " . $j . "'>" . $i * $j . "</td>";
			echo "</tr>";
		}

		echo "</table>";
	}
	else
	{
		$a = intval($x / 10);
		//a - total tables, b - number of current table

		for ($b = 0; $b < $a; $b++)
		{
			echo "<p><strong>Таблица №" . ($b + 1) . " (" . (10 * ($b + 1)) . " x " . $y .
				"):</strong></p><table cellpadding='5px' cellspacing='2px'>";

			for ($j = 1; $j <= $y; $j++) {
				echo "<tr align='center'>";
				for ($i = 10 * $b + 1; $i <= 10 * ($b + 1); $i++)
					echo "<td title='" . $i . " * " . $j . "'>" . $i * $j . "</td>";
				echo "</tr>";
			}

			echo "</table>";
		}
	}
}

?>

