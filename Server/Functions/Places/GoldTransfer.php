<?php
/**
 * Transfer Logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Gold') &&
	property_exists($Get, 'Name')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character))
	{
		if($Cell = $Database->Maps->LoadCell($Character->MapId, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000003')
			{
				if($Character->Bank > $Get->Gold)
				{
					$TargetCharacter = new \Entities\Character();
					$TargetCharacter->Name = $Get->Name;
					if($Database->Characters->CheckName($TargetCharacter))
					{
						if($Database->Characters->LoadTraits($TargetCharacter))
						{
							$TargetCharacter->Bank += $Get->Gold;
							$Character->Bank -= $Get->Gold;
							if($Database->Characters->UpdateTraits($Character) && $Database->Characters->UpdateTraits($TargetCharacter))
							{
								$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
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
						$Result->Set('Result', \Protocol\Result::ER_BADDATA);
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