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

		if(isset($_POST['Action']))
		{
			switch($_POST['Action'])
			{
				case ACTION_CREATE:
					include './Functions/Character/Create.php';
					break;
				case ACTION_LIST:
					include './Functions/Character/List.php';
					break;
				case ACTION_CHECKNAME:
					include './Functions/Character/CheckName.php';
					break;
				default:
					$Result->Set('Result', \Protocol\Result::ER_BADDATA);
					break;
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_NOTLOGGEDIN);
	}
}
$Result->Output();
?>