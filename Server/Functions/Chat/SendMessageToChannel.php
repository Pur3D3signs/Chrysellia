<?php
namespace Functions\Chat;
/**
 * Chat send logic
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
	property_exists($Get, 'Channel') &&
	property_exists($Get, 'Message')
)
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadById($Character))
	{
		if(is_array($Rights = $Database->Chat->GetRights($Character, $Get->Channel)))
		{
			if($Rights['Write'])
			{
				if($Database->Characters->LoadTraits($Character))
				{
					if($Database->Chat->Insert($Character, $Get->Channel, $Get->Message))
					{
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
					}
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
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>