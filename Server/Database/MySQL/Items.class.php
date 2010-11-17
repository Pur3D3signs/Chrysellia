<?php

namespace Database\MySQL;

define('SQL_LOADINVENTORY', 'SELECT i.itemId, i.name, i.description, i.itemType, i.createdOn, ie.sockets, ie.slots, ie.slotType FROM `items` i INNER JOIN `inventories` in ON i.inventoryId=in.inventoryId LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` is ON i.itemId=is.itemId WHERE in.characterId=? AND is.socketedIn IS NULL');

/**
 * Class that holds definitions for Item query functions
 */
class Items
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Items Queries class
	 *
	 * Contains all queries for loading Items from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Load a character's inventory
	 *
	 * @param $Character
	 *   The Character entity that will be used to load the inventory.
	 *   Must have it's character id property set
	 *
	 * @return Array
	 *   An array containing all the inventory items
	 */
	public function LoadInventory(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADINVENTORY);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AnItem = new \Entities\Item();
			$Query->bind_result($AnItem->ItemId, $AnItem->Name, $AnItem->Description, $AnItem->Type, $AnItem->CreatedOn, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$Index] = $AnItem;
				$Index++;
			}
		}

		return $Result;
	}
}
?>