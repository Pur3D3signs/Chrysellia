<?php
/**
 * Withdraw Logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Gold')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character) && $Database->Characters->LoadById($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000003')
			{
				if($Character->Bank >= $Get->Gold)
				{
					$Character->Bank -= $Get->Gold;
					$Character->Gold += $Get->Gold;
					if($Database->Characters->UpdateTraits($Character))
					{
						$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					}
					else
					{
						$Result->Set('Result', \Protocol\Result::ER_DBERROR);
					}
				}
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>