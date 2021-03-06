<?php
namespace Functions\Places;
/**
 * Buy Logic
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
	property_exists($Get, 'ItemTemplateId')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character) && $Database->Characters->LoadById($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000001')
			{
				$Success = false;
				$Database->startTransaction();
				$Item = new \Entities\Item();
				$Item->ItemTemplateId = $Get->ItemTemplateId;
				$Item->InventoryId = $Character->InventoryId;
				if($Database->Items->LoadTemplateById($Item))
				{
					if($Character->Gold >= $Item->BuyPrice)
					{	
						$Character->Gold -= $Item->BuyPrice;
						if($Database->Items->Insert($Item) && $Database->Characters->UpdateTraits($Character))
						{
							$Success = true;
						}
						else
						{
							$Response->Set('Result', \Protocol\Response::ER_DBERROR);
						}
					}
				}
				else
				{
					$Response->Set('Result', \Protocol\Response::ER_BADDATA);
				}

				if($Success)
				{
					$Database->commitTransaction();
					$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
					$Response->Set('Data', $Item);
				}
				else
				{
					$Database->rollbackTransaction();
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
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>