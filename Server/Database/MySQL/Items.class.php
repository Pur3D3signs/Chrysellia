<?php

namespace Database\MySQL;

define('IT_CONSUMABLE', 0);
define('IT_SOCKETABLE', 1);
define('IT_EQUIPPABLE', 2);

define('SQL_LOADITEM', 'SELECT i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.masteryType, ie.itemClass, ie.sockets, ie.slots, ie.slotType, isk.socketedIn FROM `items` i LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` isk ON i.itemId=isk.itemId WHERE i.itemId=?');
define('SQL_LOADITEM_TEMPLATE', 'SELECT it.name, it.description, it.buyPrice, it.sellPrice, it.itemType, ite.masteryType, ite.itemClass, ite.sockets, ite.slots, ite.slotType, ite.onEquip, ite.onUnequip, ite.onAttack, ite.onDefend, its.onSocket, itc.onUse FROM `item_templates` it LEFT JOIN `item_template_equippables` ite ON it.itemTemplateId=ite.itemTemplateId LEFT JOIN `item_template_socketables` its ON it.itemTemplateId=its.itemTemplateId LEFT JOIN `item_template_consumables` itc ON itc.itemTemplateId=it.itemTemplateId WHERE it.itemTemplateId=?');
define('SQL_DELETEITEM', 'DELETE FROM `items` WHERE `itemId`=?');

define('SQL_INSERTITEM', 'INSERT INTO  `items` (`itemId`, `itemTemplateId`, `itemType`, `inventoryId`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_CONSUMABLE', 'INSERT INTO `item_consumables` (`itemId`, `onUse`) VALUES (?, ?)');
define('SQL_INSERTITEM_EQUIPPABLE', 'INSERT INTO `item_equippables` (`itemId`, `masteryType`, `itemClass`, `sockets`, `slots`, `slotType`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_SOCKETABLE', 'INSERT INTO `item_socketables` (`itemId`, `socketedIn`, `onSocket`) VALUES (?, ?, ?)');

define('SQL_INSERTITEM_TEMPLATE', 'INSERT INTO  `item_templates` (`itemTemplateId`, `itemType`, `name`, `description`, `buyPrice`, `sellPrice`) VALUES (?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_TEMPLATE_CONSUMABLE', 'INSERT INTO  `item_template_consumables` (`itemTemplateId`, `onUse`) VALUES (?, ?)');
define('SQL_INSERTITEM_TEMPLATE_EQUIPPABLE', 'INSERT INTO  `item_template_equippables` (`itemTemplateId`, `masteryType`, `itemClass`,  `sockets`, `slots`, `slotType`, `onEquip`, `onUnequip`, `onAttack`, `onDefend`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTITEM_TEMPLATE_SOCKETABLE', 'INSERT INTO  `item_template_socketables` (`itemTemplateId`, `onSocket`) VALUES (?, ?)');

define('SQL_UPDATEITEM', 'UPDATE `items` SET `name`=?, `description`=?, `buyPrice`=?, `sellPrice`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_CONSUMABLE', 'UPDATE `item_consumables` SET `onUse`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_EQUIPPABLE', 'UPDATE `item_equippables` SET `sockets`=?, `slots`=?, `onEquip`=?, `onUnequip`=?, `onAttack`=?, `onDefend`=? WHERE `itemId`=?');
define('SQL_UPDATEITEM_SOCKETABLE', 'UPDATE `item_socketables` SET `socketedIn`=?, `onSocket`=? WHERE `itemId`=?');

define('SQL_UPDATEITEM_TEMPLATE', 'UPDATE `item_templates` SET `name`=?, `description`=?, `buyPrice`=?, `sellPrice`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_CONSUMABLE', 'UPDATE `item_template_consumables` SET `onUse`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_EQUIPPABLE', 'UPDATE `item_template_equippables` SET `sockets`=?, `slots`=?, `onEquip`=?, `onUnequip`=?, `onAttack`=?, `onDefend`=? WHERE `itemTemplateId`=?');
define('SQL_UPDATEITEM_TEMPLATE_SOCKETABLE', 'UPDATE `item_template_socketables` SET `socketedIn`=?, `onSocket`=? WHERE `itemTemplateId`=?');

define('SQL_LOADRACEDEFAULTITEMS', 'SELECT rdi.itemTemplateId, it.name, it.description, it.buyPrice, it.sellPrice, it.itemType, ite.masteryType, ite.itemClass, ite.sockets, ite.slots, ite.slotType, ite.onEquip, ite.onUnequip, ite.onAttack, ite.onDefend, its.onSocket, itc.onUse FROM `item_templates` it INNER JOIN `race_default_items` rdi ON rdi.itemTemplateId=it.itemTemplateId LEFT JOIN `item_template_equippables` ite ON it.itemTemplateId=ite.itemTemplateId LEFT JOIN `item_template_socketables` its ON it.itemTemplateId=its.itemTemplateId LEFT JOIN `item_template_consumables` itc ON itc.itemTemplateId=it.itemTemplateId WHERE rdi.raceId=?');

define('SQL_ITEMCHANGEINVENTORY', 'UPDATE `items` SET `inventoryId`=? WHERE `itemId`=?');
define('SQL_LOADINVENTORY', 'SELECT i.itemId, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.masteryType, ie.itemClass, ie.sockets, ie.slots, ie.slotType FROM `items` i INNER JOIN `inventories` inv ON i.inventoryId=inv.inventoryId LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` isk ON i.itemId=isk.itemId WHERE inv.characterId=? AND isk.socketedIn IS NULL AND i.itemId NOT IN(SELECT itemId FROM `character_equipment` WHERE `characterId`=inv.characterId)');
define('SQL_INSERTINVENTORYFORCHARACTER', 'INSERT INTO `inventories` (`inventoryId`, `characterId`) VALUES (?, ?)');
define('SQL_ITEMGETOWNERSHIP', 'SELECT inv.characterId FROM `inventories` inv INNER JOIN `items` i ON i.inventoryId=inv.inventoryId WHERE i.itemId=? AND i.itemId NOT IN(SELECT `itemId` FROM `character_equipment` WHERE `characterId`=inv.characterId) AND i.itemId NOT IN(SELECT `itemId` FROM `trade_items`)');

define('SQL_INSERTTRADE', 'INSERT INTO `trades` (`tradeId`, `inventoryTo`, `inventoryFrom`, `cost`) VALUES (?, ?, ?, ?)');
define('SQL_INSERTTRADEITEM', 'INSERT INTO `trade_items` (`tradeId`, `sendRecv`, `itemId`) VALUES (?, ?, ?)');
define('SQL_LOADTRADE', 'SELECT t.tradeId, ti.sendRecv, inventoryIdTo, inventoryIdFrom, ti.itemId, t.cost, it.itemTemplateId FROM `trades` t INNER JOIN `trade_items` ti ON t.tradeId=ti.tradeId INNER JOIN `items` i ON i.itemId=ti.itemId WHERE t.tradeId=?');
define('SQL_DELETETRADE', 'DELETE FROM `trades` WHERE `tradeId`=?');
define('SQL_LOADINCOMINGTRADES', 'SELECT t.tradeId, ti.sendRecv, inventoryIdTo, inventoryIdFrom, ti.itemId, t.cost, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, ie.masteryType, ie.itemClass, ie.sockets, ie.slots, ie.slotType FROM `trades` t INNER JOIN `trade_items` ti ON t.tradeId=ti.tradeId INNER JOIN `items` i ON i.itemId=ti.itemId INNER JOIN `inventories` inv ON inv.inventoryId=t.inventoryIdTo LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` isk ON i.itemId=isk.itemId WHERE inv.characterId=?');
define('SQL_LOADOUTGOINGTRADES', 'SELECT t.tradeId, ti.sendRecv, inventoryIdTo, inventoryIdFrom, ti.itemId, t.cost, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, ie.masteryType, ie.itemClass, ie.sockets, ie.slots, ie.slotType FROM `trades` t INNER JOIN `trade_items` ti ON t.tradeId=ti.tradeId INNER JOIN `items` i ON i.itemId=ti.itemId INNER JOIN `inventories` inv ON inv.inventoryId=t.inventoryIdFrom LEFT JOIN `item_equippables` ie ON i.itemId=ie.itemId LEFT JOIN `item_socketables` isk ON i.itemId=isk.itemId WHERE inv.characterId=?');

define('SQL_GETEQUIPPEDITEMS', 'SELECT e.itemId, e.slotType, e.slots, e.slotNumber, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, i.createdOn, ie.masteryType, ie.itemClass, ie.sockets FROM `character_equipment` e INNER JOIN `items` i ON i.itemId=e.itemId INNER JOIN `item_equippables` ie ON ie.itemId=i.itemId WHERE e.characterId=? ORDER BY e.slotNumber ASC');
define('SQL_EQUIPITEM', 'INSERT INTO  `character_equipment` (`characterId`, `itemId`, `slotType`, `slots`, `slotNumber`) VALUES (?, ?, ?, ?, ?)');
define('SQL_UNEQUIPITEM', 'DELETE FROM `character_equipment` WHERE `characterId`=? AND `itemId`=?');

define('SQL_LOADTEMPLATES', 'SELECT i.itemTemplateId, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, ie.masteryType, ie.itemClass, ie.sockets, ie.slots, ie.slotType FROM `item_templates` i  LEFT JOIN `item_template_equippables` ie ON i.itemTemplateId=ie.itemTemplateId');

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
	 * Load an Item
	 *
	 * @param $Item
	 *   The Item entity that will be loaded
	 *   Must have it's itemId property set
	 *
	 * @return Boolean
	 *   Whether or not the load succeeded
	 */
	public function LoadById(\Entities\Item $AnItem)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADITEM);
		$Query->bind_param('s', $AnItem->ItemId);

		$Query->Execute();
		$Query->bind_result($AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->CreatedOn, $AnItem->MasteryType, $AnItem->ItemClass, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType, $AnItem->SocketedIn);
		if($Query->Fetch())
			return true;
		else
			return false;
	}

	/**
	 * Load an Item Template
	 *
	 * @param $Item
	 *   The Item entity that will be loaded
	 *   Must have it's itemTemplateId property set
	 *
	 * @return Boolean
	 *   Whether or not the load succeeded
	 */
	public function LoadTemplateById(\Entities\Item $AnItem)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADITEM_TEMPLATE);
		$Query->bind_param('s', $AnItem->ItemTemplateId);

		$Query->Execute();
		$Query->bind_result($AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->MasteryType, $AnItem->ItemClass, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType, $AnItem->OnEquip, $AnItem->OnUnequip, $AnItem->OnAttack, $AnItem->OnDefend, $AnItem->OnSocket, $AnItem->OnUse );
		if($Query->Fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Item
	 *
	 * @param $Item
	 *   The Item entity that will be Inserted
	 *   Must have it's itemTemplateId property set
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function Insert(\Entities\Item $Item)
	{
		$Item->ItemId = uniqid('ITEM_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTITEM);
		$Query->bind_param('ssisssii', $Item->ItemId, $Item->ItemTemplateId, $Item->Type, $Item->InventoryId, $Item->Name, $Item->Description, $Item->BuyPrice, $Item->SellPrice);
		$Query->Execute();

		if($Query->affected_rows > 0)
		{
			$Query->close();
			$Query2 = null;
			switch($Item->Type)
			{
				case IT_CONSUMABLE:
					$Query2 = $this->Database->Connection->prepare(SQL_INSERTITEM_CONSUMABLE);
					$Query2->bind_param('ss', $Item->ItemId, $Item->OnUse);
					break;
				case IT_SOCKETABLE:
					$Query2 = $this->Database->Connection->prepare(SQL_INSERTITEM_SOCKETABLE);
					$Query2->bind_param('sss', $Item->ItemId, $Item->SocketedIn, $Item->OnSocket);
					break;
				case IT_EQUIPPABLE:
					$Query2 = $this->Database->Connection->prepare(SQL_INSERTITEM_EQUIPPABLE);
					$Query2->bind_param('siiiiissss', $Item->ItemId, $Item->MasteryType, $Item->ItemClass, $Item->Sockets, $Item->Slots, $Item->SlotType, $Item->OnEquip, $Item->OnUnequip, $Item->OnAttack, $Item->OnDefend);
					break;
				default:
					return true;
					break;
			}
			if($Query2 != null)
			{
				$Query2->Execute();
				if($Query2->affected_rows > 0)
					return true;
				else
					return false;
			}else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}



	/**
	 * Insert an inventory for a character
	 *
	 * @param $Character
	 *   The Character entity that will be used to load the inventory.	/**
	 * Insert an Inventory for a character
	 *
	 * @param $Character
	 *   The Character entity that the inventory will belong to
	 *   Must have it's characterId property set
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function InsertInventoryForCharacter(\Entities\Character $Character)
	{
		$InventoryId = uniqid('IVTY_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTINVENTORYFORCHARACTER);
		$Query->bind_param('ss', $InventoryId, $Character->CharacterId);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return $InventoryId;
		else
			return false;
	}

	/**
	 * Insert an inventory for a character
	 *
	 * @param $Item
	 *   The item to be deleted
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function Delete(\Entities\Item $Item)
	{
		$Query = $this->Database->Connection->prepare(SQL_DELETEITEM);
		$Query->bind_param('s', $Item->ItemId);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Load a character's inventory
	 *
	 * @param $Character
	 *   The Character entity that the inventory will belong to
	 *   Must have it's character Id property set
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
			$Query->bind_result($AnItem->ItemId, $AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->CreatedOn, $AnItem->MasteryType, $AnItem->ItemClass, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$Index] = $AnItem;
				$Index++;
			}
		}

		return $Result;
	}

	/**
	 * Load a race's default items
	 *
	 * @param $Race
	 *   The race entity that will be used to load the list.
	 *   Must have it's race id property set
	 *
	 * @return Array
	 *   An array containing all the default items
	 */
	public function LoadRaceDefaultItems(\Entities\Race $Race)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADRACEDEFAULTITEMS);
		$Query->bind_param('s', $Race->RaceId);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AnItem = new \Entities\Item();
			$Query->bind_result($AnItem->ItemTemplateId, $AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->MasteryType, $AnItem->ItemClass,  $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType, $AnItem->OnEquip, $AnItem->OnUnequip, $AnItem->OnAttack, $AnItem->OnDefend, $AnItem->OnSocket, $AnItem->OnUse);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$Index] = $AnItem;
				$Index++;
			}
		}

		return $Result;
	}

	/**
	 * LoadEquippedItems
	 *
	 * @param $Character
	 *   The character from which we are loading equipped items
	 *
	 * @return Array
	 *   An array containing all the equipped items
	 */
	public function LoadEquippedItems(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETEQUIPPEDITEMS);
		$Query->bind_param('s', $Character->CharacterId);
		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AnItem = new \Entities\Item();
			$Query->bind_result($AnItem->ItemId, $AnItem->SlotType, $AnItem->Slots, $AnItem->SlotNumber, $AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->ItemType, $AnItem->CreatedOn, $AnItem->MasteryType, $AnItem->ItemClass, $AnItem->Sockets);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$Index] = $AnItem;
				$Index++;
			}
		}

		return $Result;
	}

	/**
	 * Equips an item in a slot
	 *
	 * @param $Character
	 *   The Character entity that will have an item equipped
	 *   Must have it's characterId property set
	 *
	 * @param $Item
	 *   The Item entity will be equipped
	 *   Must have it's ItemId, SlotType, and slots properties set 
	 *
	 * @param $SlotNumber
	 *   The slot which the item should be equipped in
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function EquipItem(\Entities\Character $Character, \Entities\Item $Item, $SlotNumber)
	{
		$Query = $this->Database->Connection->prepare(SQL_EQUIPITEM);
		$Query->bind_param('ssiii', $Character->CharacterId, $Item->ItemId, $Item->SlotType, $Item->Slots, $SlotNumber);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Equips an item in a slot
	 *
	 * @param $Character
	 *   The Character entity that will have an item equipped
	 *   Must have it's characterId property set
	 *
	 * @param $Item
	 *   The Item entity will be equipped
	 *   Must have it's ItemId, SlotType, and slots properties set 
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function UnequipItem(\Entities\Character $Character, \Entities\Item $Item)
	{
		$Query = $this->Database->Connection->prepare(SQL_UNEQUIPITEM);
		$Query->bind_param('ss', $Character->CharacterId, $Item->ItemId);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Checks to see if a character owns an item
	 *
	 * @param $Character
	 *   The Character entity that will have an item equipped
	 *   Must have it's characterId property set
	 *
	 * @param $Item
	 *   The Item entity will be equipped
	 *   Must have it's ItemId property set
	 *
	 * @return Boolean
	 *   Whether or not the item belongs to the character
	 */
	public function CharacterOwnsItem(\Entities\Character $Character, \Entities\Item $Item)
	{
		$Query = $this->Database->Connection->prepare(SQL_ITEMGETOWNERSHIP);
		$Query->bind_param('s', $Item->ItemId);
		$Query->Execute();
		$Query->bind_result($CharacterId);
		$Query->Fetch();
		if($CharacterId == $Character->CharacterId)
			return true;
		else
			return false;
	}

	/**
	 * Insert a trade between 2 inventory Ids
	 *
	 * @param $InventoryIdSource
	 *   The source InventoryId
	 *
	 * @param $InventoryIdDestination
	 *   The destination InventoryId
	 *
	 * @param $Cost
	 *   The gold to be traded
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function InsertTrade($InventoryIdSource, $InventoryIdDestination, $Cost)
	{
		$TradeId = uniqid('TRAD_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTTRADE);
		$Query->bind_param('sssi', $TradeId, $InventoryIdDestination, $InventoryIdSource, $Cost);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return $TradeId;
		else
			return false;
	}

	/**
	 * Insert a trade item
	 *
	 * @param $TradeId
	 *   The source InventoryId
	 *
	 * @param $Item
	 *   The Item to be traded
	 *
	 * @param $SendRecv
	 *   Whether the item is coming or going
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function InsertTradeItem($TradeId, \Entities\Item $Item, $SendRecv)
	{
		$TradeId = uniqid('TRAD_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTTRADEITEM);
		$Query->bind_param('sssi', $TradeId, $InventoryIdDestination, $InventoryIdSource, $Cost);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Load a trade
	 *
	 * @param $TradeId
	 *   The source InventoryId
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function LoadTrade($TradeId)
	{
		$Result = array();
		$Query = $this->Database->Connection->prepare(SQL_LOADTRADE);
		$Query->bind_param('s', $TradeId);
		$Query->Execute();
		$Array = array();
		$Query->bind_result($Array['TradeId'], $Array['SendRecv'], $Array['InventoryTo'], $Array['InventoryFrom'], $Array['ItemId'], $Array['Cost'], $Array['ItemTemplateId']);
		while($Query->Fetch())
		{
			array_push($Result, $Array);
		}
		return $Result;
	}

	/**
	 * Load incoming trades
	 *
	 * @param $Character
	 *   A character entity
	 *
	 * @return Boolean
	 *   Whether or not the load succeeded
	 */
	public function LoadIncomingTrades(\Entities\Character $Character)
	{
		$Result = array();
		$Query = $this->Database->Connection->prepare(SQL_LOADINCOMINGTRADES);
		$Query->bind_param('s', $Character->CharacterId);
		$Query->Execute();
		$Array = array();
		$Query->bind_result($Array['TradeId'], $Array['SendRecv'], $Array['InventoryTo'], $Array['InventoryFrom'], $Array['ItemId'], $Array['Cost'], $Array['ItemName'], $Array['Description'], $Array['BuyPrice'], $Array['SellPrice'], $Array['ItemType'], $Array['MasteryType'], $Array['ItemClass'], $Array['Sockets'], $Array['Slots'], $Array['SlotType']);
		while($Query->Fetch())
		{
			array_push($Result, $Array);
		}
		return $Result;
	}

	/**
	 * Load incoming trades
	 *
	 * @param $Character
	 *   A character entity
	 *
	 * @return Boolean
	 *   Whether or not the load succeeded
	 */
	public function LoadOutgoingTrades(\Entities\Character $Character)
	{
		$Result = array();
		$Query = $this->Database->Connection->prepare(SQL_LOADINCOMINGTRADES);
		$Query->bind_param('s', $Character->CharacterId);
		$Query->Execute();
		$Array = array();
		$Query->bind_result($Array['TradeId'], $Array['SendRecv'], $Array['InventoryTo'], $Array['InventoryFrom'], $Array['ItemId'], $Array['Cost'], $Array['ItemName'], $Array['Description'], $Array['BuyPrice'], $Array['SellPrice'], $Array['ItemType'], $Array['MasteryType'], $Array['ItemClass'], $Array['Sockets'], $Array['Slots'], $Array['SlotType']);
		while($Query->Fetch())
		{
			array_push($Result, $Array);
		}
		return $Result;
	}

	/**
	 * Delete a trade
	 *
	 * @param $TradeId
	 *   The source TradeId
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function DeleteTrade($TradeId)
	{
		$Result = array();
		$Query = $this->Database->Connection->prepare(SQL_DELETETRADE);
		$Query->bind_param('s', $TradeId);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Change Inventory
	 *
	 * @param $Character
	 *   The Character entity that will have an item equipped
	 *   Must have it's characterId property set
	 *
	 * @param $Item
	 *   The Item entity will be equipped
	 *   Must have it's ItemId, SlotType, and slots properties set 
	 *
	 * @param $SlotNumber
	 *   The slot which the item should be equipped in
	 *
	 * @return Boolean
	 *   Whether or not the insert succeeded
	 */
	public function ChangeInventory(\Entities\Item $Item, $InventoryId)
	{
		$Query = $this->Database->Connection->prepare(SQL_ITEMCHANGEINVENTORY);
		$Query->bind_param('ss', $Item->ItemId, $InventoryId);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}
	
	public function LoadAllItemTemplates()
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADTEMPLATES);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AnItem = new \Entities\Item();
			//i.itemTemplateId, i.name, i.description, i.buyPrice, i.sellPrice, i.itemType, ie.masteryType, ie.itemClass, ie.sockets, ie.slots, ie.slotType
			$Query->bind_result($AnItem->ItemId, $AnItem->Name, $AnItem->Description, $AnItem->BuyPrice, $AnItem->SellPrice, $AnItem->Type, $AnItem->MasteryType, $AnItem->ItemClass, $AnItem->Sockets, $AnItem->Slots, $AnItem->SlotType);
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