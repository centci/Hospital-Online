<?php

require "config.php";
require "function.php";

spl_autoload_register('Autoload');

	function Autoload($className)
	{
    if (file_exists("../private/core/". ucfirst($className) .".php"))
    {
      require "../private/core/". ucfirst($className) .".php";
    }
    elseif (file_exists("../private/models/". ucfirst($className) .".php"))
    {
      require "../private/models/". ucfirst($className) .".php";
    }
  }
