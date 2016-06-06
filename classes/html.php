<?php

define('TYPE_TEMPLATE', 0);
define('TYPE_META', 1);

class HTML
{
	static public $SiteName = "MySite";
	static $templates = [];
	static $js = [];
	static $css = [];
	static public $templates_dir = "templates/";

	static public function header( $title = "" )
	{
		if ($title == "")
			$title = HTML::$SiteName;
		else
			$title = HTML::$SiteName . " - " . $title;

		HTML::template("header", array($title));
	}

	static public function footer()
	{
		HTML::template("footer");
	}

	static public function template($name, $args = array())
	{
		if (file_exists(HTML::$templates_dir . $name . ".meta.php"))
			HTML::$templates[] = array($name . ".meta", array(), TYPE_META);
		HTML::$templates[] = array($name, $args, TYPE_TEMPLATE);
	}

	static function flush()
	{
		foreach (HTML::$templates as $t)
		{
			list($name, $args, $type) = $t;
			if ($type != TYPE_META)
				continue;
			include(HTML::$templates_dir . $name . ".php");
		}
		foreach (HTML::$templates as $t)
		{
			list($name, $args, $type) = $t;
			if ($type == TYPE_META)
				continue;
			include(HTML::$templates_dir . $name . ".php");
		}
	}

	static function include_js($name)
	{
		HTML::$js[] = $name;
	}

	static function put_js()
	{
		HTML::$js = array_unique(HTML::$js);
		foreach (HTML::$js as $name)
			echo "<script type='text/javascript' src='js/" . $name . "'></script>";
	}

	static function include_css($name)
	{
		HTML::$css[] = $name;
	}

	static function put_css()
	{
		HTML::$css = array_unique(HTML::$css);
		foreach (HTML::$js as $name)
			echo "<link rel='stylesheet' href='css/" . $name . "'></script>";
	}
}

?>