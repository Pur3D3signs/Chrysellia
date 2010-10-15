<?php
require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']))
	{
		define('ACTION_CREATE', 0);
		define('ACTION_LIST', 1);
		define('ACTION_CHECKNAME', 2);

		if(isset($_POST['Data']))
		{
			$Post = json_decode($_POST['Data']);
			if(property_exists($Post, 'Action'))
			{
				switch($Post->Action)
				{
					case ACTION_CREATE:
						include('./Functions/Character/Create.php');
						break;
					case ACTION_LIST:
						include('./Functions/Character/List.php');
						break;
					case ACTION_CHECKNAME:
						include('./Functions/Character/CheckName.php');
						break;
					default:
						$Result->Set('Result', ER_BADDATA);
						break;
				}
			}
			else
			{
				$Result->Set('Result', ER_MALFORMED);
			}
		}
		else
		{
			$Result->Set('Result', ER_MALFORMED);
		}
	}
}
$Result->Output();
?>