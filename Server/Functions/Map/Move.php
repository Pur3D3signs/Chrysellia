<?php
namespace Functions\Map;
/**
 * Character movement logic
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new \stdClass();
}

if(
	property_exists($Get, 'X') &&
	property_exists($Get, 'Y')
){
	if(
		($Get->X >= 0) &&
		($Get->Y >= 0)
	){
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadPosition($Character))
		{
			$DiffX = abs($Character->PositionX - $Get->X);
			$DiffY = abs($Character->PositionY - $Get->Y);
			if(
				($DiffX <= 1) &&
				($DiffY <= 1)
			){
				$Map = new \Entities\Map();
				$Map->MapId = $Character->MapId;
				if($Database->Maps->LoadMapById($Map))
				{
					if(
						($Get->X < $Map->DimensionX) &&
						($Get->Y < $Map->DimensionY)
					){
						$Cell = $Database->Maps->LoadCell($Map, $Get->X, $Get->Y);
						if(!$Cell['Blocked'])
						{
							if($DiffX + $DiffY == 2)
							{
								$_SESSION['NextAction'] = microtime(true) + .282;
							}
							else
							{
								$_SESSION['NextAction'] = microtime(true) + .200;
							}
							$Character->PositionX = $Get->X;
							$Character->PositionY = $Get->Y;
							if($Database->Characters->UpdatePosition($Character))
							{
								$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
								$Response->Set('Data', Array('X'=>$Get->X, 'Y'=>$Get->Y));
							}
							else
							{
								$Response->Set('Result', \Protocol\Response::ER_DBERROR);
							}
						}
					}
				}
				else
				{
					$Response->Set('Result', \Protocol\Response::ER_DBERROR);
				}
			}
			else
			{
				$Response->Set('Result', \Protocol\Response::ER_BADDATA);
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>