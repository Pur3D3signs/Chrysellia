<?php

namespace Database\MySQL;

//Queries
//Basic
define('SQL_ISONLINE', 'SELECT count(*) FROM `sessions` WHERE `characterId`=?');
define('SQL_GETCHARACTERSBYACCOUNTID', 'SELECT c.characterId, c.pin, c.name, c.createdOn, ct.strength, ct.dexterity, ct.intelligence, ct.wisdom, ct.vitality, ct.health, ct.alignGood, ct.alignOrder, ct.raceId, ct.gold, ct.gender, cl.mapId, cl.positionX, cl.positionY, ct.level, ct.freelevels, ct.experience FROM `characters` c INNER JOIN `character_traits` ct ON c.characterId=ct.characterId INNER JOIN `character_locations` cl ON c.characterId=cl.characterId WHERE c.accountId=?');
define('SQL_GETCHARACTERBYID', 'SELECT c.accountId, c.pin, c.name, c.createdOn, inv.inventoryId, c.clanId FROM `characters` c INNER JOIN `inventories` inv ON c.characterId=inv.characterId WHERE c.characterId=?');
define('SQL_INSERTCHARACTER', 'INSERT INTO `characters` (`accountId`, `characterId`, `pin`, `name`) VALUES (?, ?, ?, ?)');
define('SQL_GETCHARACTERCOUNT', 'SELECT count(*) FROM `characters` WHERE `accountId`=?');
define('SQL_CHECKCHARACTERNAME', 'SELECT `characterId` FROM `characters` WHERE `name`=?');

//Traits
define('SQL_GETCHARACTERTRAITS', 'SELECT `raceId`, `gender`, `alignGood`, `alignOrder`, `level`, `freelevels`, `experience`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `health`, `experienceBonus`, `alignBonus`, `strengthBonus`, `dexterityBonus`, `intelligenceBonus`, `wisdomBonus`, `vitalityBonus`, `gold`, `bank` FROM `character_traits` WHERE `characterId`=?');
define('SQL_UPDATECHARACTERTRAITS', 'UPDATE `character_traits` SET `alignGood`=?, `alignOrder`=?, `level`=?, `freelevels`=?, `experience`=?, `strength`=?, `dexterity`=?, `intelligence`=?, `wisdom`=?, `vitality`=?, `health`=?, `experienceBonus`=?, `alignBonus`=?, `strengthBonus`=?, `dexterityBonus`=?, `intelligenceBonus`=?, `wisdomBonus`=?, `vitalityBonus`=?, `gold`=?, `bank`=? WHERE `characterId`=?');
define('SQL_GETCHARACTERRACETRAITS', 'SELECT (rt.strength + r.strength) AS `strength`, (rt.dexterity + r.dexterity) AS `dexterity`, (rt.wisdom + r.wisdom) AS `wisdom`, (rt.intelligence + r.intelligence) AS `intelligence`, (rt.vitality + r.vitality) AS `vitality`, `racialAbility` FROM `character_race_traits` rt INNER JOIN `character_traits` ct ON ct.characterId=rt.characterId INNER JOIN `races` r ON r.raceId=ct.raceId  WHERE rt.characterId=?');
define('SQL_INSERTCHARACTERTRAITS', 'INSERT INTO `character_traits` (`characterId`, `raceId`, `gender`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `health`, `gold`, `alignGood`, `alignOrder`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTCHARACTERRACETRAITS', 'INSERT INTO `character_race_traits` (`characterId`, `strength`, `dexterity`, `wisdom`, `intelligence`, `vitality`, `racialAbility`) VALUES (?, ?, ?, ?, ?, ?, ?)');

//Location
define('SQL_GETCHARACTERLOCATION', 'SELECT `mapId`, `positionX`, `positionY` FROM `character_locations` WHERE `characterId`=?');
define('SQL_UPDATECHARACTERLOCATION', 'UPDATE `character_locations` SET `mapId`=?, `positionX`=?, `positionY`=? WHERE `characterId`=?');
define('SQL_UPDATECHARACTERLOCATIONXY', 'UPDATE `character_locations` SET `positionX`=?, `positionY=?` WHERE `characterId`=?');
define('SQL_INSERTCHARACTERLOCATION', 'INSERT INTO `character_locations` (`characterId`, `mapId`, `positionX`, `positionY`) VALUES (?, ?, ?, ?)');

define('SQL_LOADLISTFORCELL', 'SELECT c.characterId, c.name, ct.gender, ct.raceId, c.clanId, ct.level, ct.alignGood, ct.alignOrder FROM `characters` c INNER JOIN `character_locations` cl ON cl.characterId=c.characterId INNER JOIN `character_traits` ct ON ct.characterId=c.characterId WHERE cl.mapId=? AND cl.positionX=? AND cl.positionY=? AND ct.Health > 0');

//Masteries
define('SQL_LOADMASTERIESFORCHARACTER', 'SELECT `masteryId`, `value`, `masteryBonus` FROM `character_masteries` WHERE `characterId`=?');
define('SQL_UPDATEMASTERYFORCHARACTER', 'UPDATE `character_masteries` SET `value`=?, `masteryBonus`=? WHERE `characterId`=? AND `masteryId`=?');
define('SQL_INSERTMASTERYFORCHARACTER', 'INSERT INTO `character_masteries` (`characterId`, `masteryId`, `value`) VALUES(?, ?, ?)');

//API
define('SQL_LOADTOPLIST', 'SELECT c.name, ct.gender, ct.raceId, c.clanId, ct.level, ct.alignGood, ct.alignOrder FROM `characters` c INNER JOIN `character_traits` ct ON ct.characterId=c.characterId');
define('SQL_LIMIT', ' LIMIT ?, ?');
define('SQL_ORDERBY', ' ORDER BY ');
define('SQL_GETCOUNT', 'SELECT count(*) FROM `characters`');

/**
 * Contains properties and methods related to querying our characters table and relations
 */
class Characters extends \Database\Characters
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Characters Queries class
	 *
	 * Contains all queries for loading Characters from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Fill Character Object with data by searching for it by ID
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadById(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERBYID);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->AccountId, $Character->Pin, $Character->Name, $Character->CreatedOn, $Character->InventoryId, $Character->ClanId);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with data by searching for it by Account ID
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Array
	 *   An Array of \Entities\Character objects
	 */
	function LoadListByAccountId(\Entities\Account $Account)
	{
		$Result = Array();
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERSBYACCOUNTID);
		$Query->bind_param('s', $Account->AccountId);

		$Query->Execute();

		$Query->bind_result($CharacterId, $Pin, $Name, $CreatedOn, $Strength, $Dexterity, $Intelligence, $Wisdom, $Vitality, $Health, $AlignGood, $AlignOrder, $RaceId, $Gold, $Gender, $MapId, $PositionX, $PositionY, $Level, $FreeLevels, $Experience);

		while($Query->fetch())
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $CharacterId;
			if(($Pin > 0) && ($Pin != null))
				$Character->HasPin = true;
			else
				$Character->HasPin = false;
			$Character->Name = $Name;
			$Character->CreatedOn = $CreatedOn;
			$Character->Strength = $Strength;
			$Character->Dexterity = $Dexterity;
			$Character->Intelligence = $Intelligence;
			$Character->Wisdom = $Wisdom;
			$Character->Vitality = $Vitality;
			$Character->Health = $Health;
			$Character->AlignGood = $AlignGood;
			$Character->AlignOrder = $AlignOrder;
			$Character->RaceId = $RaceId;
			$Character->Gold = $Gold;
			$Character->Gender = $Gender;
			$Character->MapId = $MapId;
			$Character->PositionX = $PositionX;
			$Character->PositionY = $PositionY;
			$Character->Level = $Level;
			$Character->FreeLevels = $FreeLevels;
			$Character->Experience = $Experience;
			array_push($Result, $Character);
		}
		return $Result;
	}

	/**
	 * Insert an Character object into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function Insert(\Entities\Character $Character)
	{
		$Character->CharacterId = uniqid('CHAR_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTER);
		$Query->bind_param('ssis', $Character->AccountId, $Character->CharacterId, $Character->Pin, $Character->Name);
		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's trait data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERTRAITS);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->RaceId, $Character->Gender, $Character->AlignGood, $Character->AlignOrder, $Character->Level, $Character->FreeLevels, $Character->Experience, $Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality, $Character->Health, $Character->ExperienceBonus, $Character->AlignBonus, $Character->StrengthBonus, $Character->DexterityBonus, $Character->IntelligenceBonus, $Character->WisdomBonus, $Character->VitalityBonus, $Character->Gold, $Character->Bank);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's traits into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTERTRAITS);
		$Query->bind_param('ssiiiiiiiiii', $Character->CharacterId, $Character->RaceId, $Character->Gender, $Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality, $Character->Health, $Character->Gold, $Character->AlignGood, $Character->AlignOrder);
		$Query->Execute();
		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's race trait data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadRaceTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERRACETRAITS);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->RacialStrength, $Character->RacialDexterity, $Character->RacialWisdom, $Character->RacialIntelligence, $Character->RacialVitality, $Character->RacialAbilityId);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's racial traits into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertRaceTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTERRACETRAITS);
		$Query->bind_param('sssssss', $Character->CharacterId, $Character->RacialStrength, $Character->RacialDexterity, $Character->RacialWisdom, $Character->RacialIntelligence, $Character->RacialVitality, $Character->RacialAbilityId);

		$Query->Execute();
		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadPosition(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERLOCATION);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->MapId, $Character->PositionX, $Character->PositionY);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function UpdatePosition(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATECHARACTERLOCATION);
		$Query->bind_param('siis', $Character->MapId, $Character->PositionX, $Character->PositionY, $Character->CharacterId);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function UpdatePositionXY(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATECHARACTERLOCATION);
		$Query->bind_param('sss', $Character->CharacterId, $Character->PositionX, $Character->PositionY);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's position data into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertPosition(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTERLOCATION);
		$Query->bind_param('ssss', $Character->CharacterId, $Character->MapId, $Character->PositionX, $Character->PositionY);

		$Query->Execute();
		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Gets a count of all characters attached to an account.
	 *
	 * @param $Account
	 *   The Account entity that will be used to lookup the characters
	 *
	 * @return int
	 *   Number of characters
	 */
	public function GetCount(\Entities\Account $Account)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERCOUNT);
		$Query->bind_param('s', $Account->AccountId);

		$Query->Execute();

		$Query->bind_result($Count);

		$Query->fetch();
		return $Count;
	}

	/**
	 * Checks to see if a character's name is already in use
	 *
	 * @param $Character
	 *   The Character entity that will be checked
	 *
	 * @return Boolean
	 *   If the name is not in use, true. Otherwise false.
	 */
	public function CheckName(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_CHECKCHARACTERNAME);
		$Query->bind_param('s', $Character->Name);

		$Query->Execute();

		$Query->bind_result($Character->CharacterId);

		
		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Update a character's traits row
	 *
	 * @param $Character
	 *   The Character object that will be updated.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function UpdateTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATECHARACTERTRAITS);
		$Query->bind_param('iiiiiiiiiiiiiiiiiiiis', $Character->AlignGood, $Character->AlignOrder, $Character->Level, $Character->FreeLevels, $Character->Experience, $Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality, $Character->Health, $Character->ExperienceBonus, $Character->AlignBonus, $Character->StrengthBonus, $Character->DexterityBonus, $Character->IntelligenceBonus, $Character->WisdomBonus, $Character->VitalityBonus, $Character->Gold, $Character->Bank, $Character->CharacterId);
		$Query->Execute();
		
		if($Query->affected_rows > -1)
			return true;
		else
			return false;
	}


	/**
	 * Loads a list of characters in a cell
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Array
	 *   An Array of \Entities\Character objects
	 */
	function LoadListForCell(\Entities\Character $ACharacter)
	{
		$Result = Array();
		$Query = $this->Database->Connection->prepare(SQL_LOADLISTFORCELL);
		$Query->bind_param('sss', $ACharacter->MapId, $ACharacter->PositionX, $ACharacter->PositionY);

		$Query->Execute();

		$Query->bind_result($CharacterId, $Name, $Gender, $RaceId, $ClanId, $Level, $AlignGood, $AlignOrder);

		while($Query->fetch())
		{
			if($ACharacter->CharacterId != $CharacterId)
			{
				$Character = new \Entities\Character();
				$Character->CharacterId = $CharacterId;
				$Character->Name = $Name;
				$Character->RaceId = $RaceId;
				$Character->Gender = $Gender;
				$Character->ClanId = $ClanId;
				$Character->Level = $Level;
				$Character->AlignGood = $AlignGood;
				$Character->AlignOrder = $AlignOrder;
				array_push($Result, $Character);
			}
		}
		return $Result;
	}

	/**
	 * Loads a list of characters for API
	 *
	 * @return Array
	 *   An Array of \Entities\Character objects
	 */
	function LoadTopList($NumRows=10, $Position=0, $Direction=0, $ListType=0, $ByRace=null)
	{
		$Result = Array();
		$Query = null;
		$Field = 'ct.level';
		$DirectionString = ' ASC';
		if(!$Direction)
			$DirectionString=' DESC';
		$Where='';
		if(isset($ByRace) && $ByRace != "")
		{
			$Where = ' WHERE ct.raceId="'.$this->Database->Connection->real_escape_string($ByRace).'"';
		}
		switch($ListType)
		{
			case 0 :
				$Field = 'ct.level';
				break;
			case 1 :
				$Field = 'ct.alignGood';
				break;
			case 2 :
				$Field = 'ct.alignOrder';
				break;
		}

		$Query = $this->Database->Connection->prepare(SQL_LOADTOPLIST.$Where.SQL_ORDERBY.$Field.$DirectionString.SQL_LIMIT);

		$Query->bind_param('ii', $Position, $NumRows);

		$Query->Execute();

		$Query->bind_result($Name, $Gender, $RaceId, $ClanId, $Level, $AlignGood, $AlignOrder);

		while($Query->fetch())
		{
			$Character = new \Entities\Character();
			$Character->Name = $Name;
			$Character->RaceId = $RaceId;
			$Character->Gender = $Gender;
			$Character->ClanId = $ClanId;
			$Character->Level = $Level;
			$Character->AlignGood = $AlignGood;
			$Character->AlignOrder = $AlignOrder;
			array_push($Result, $Character);
		}
		return $Result;
	}

	/**
	 * Get total character count
	 *
	 * @return int
	 *   How many characters there are in the db
	 */
	function GetTotalCount($ByRace=null)
	{
		$Where='';
		if(isset($ByRace))
		{
			$Where = ' WHERE c.raceId="'.$this->Database->Connection->real_escape_string($ByRace).'"';
		}
		$Query = $this->Database->Connection->prepare(SQL_GETCOUNT.$Where);
		$Query->Execute();

		$Query->bind_result($Count);
		$Query->fetch();
		return $Count;
	}

	/**
	 * Load a character's masteries
	 *
	 * @param $Character
	 *   The character entity that will be used to load the list.
	 *   Must have it's character id property set
	 *
	 * @return Array
	 *   An array containing all the masteries
	 */
	public function LoadMasteries(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADMASTERIESFORCHARACTER);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		while($Continue)
		{
			$AMastery = array();
			$Query->bind_result($AMastery['MasteryId'], $AMastery['Value'], $AMastery['Bonus']);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$AMastery['MasteryId']] = $AMastery;
			}
		}

		return $Result;
	}

	/**
	 * Update a character's mastery value
	 *
	 * @param $Character
	 *   The Character object that will be updated.
	 *
	 * @param $MasteryId
	 *   The Mastery to be updated
	 *
	 * @param $Value
	 *   The new mastery value
	 *
	 * @param $Bonus
	 *   The new mastery bonus
	 *
	 * @return Boolean
	 *   Whether the mastery row was successfully updated or not
	 */
	function UpdateMastery(\Entities\Character $Character, $MasteryId, $Value, $Bonus)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATEMASTERYFORCHARACTER);
		$Query->bind_param('iisi', $Value, $Bonus, $Character->CharacterId, $MasteryId);
		$Query->Execute();
		
		if($Query->affected_rows > -1)
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's position data into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertMastery(\Entities\Character $Character, $MasteryId, $Value)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTMASTERYFORCHARACTER);
		$Query->bind_param('sii', $Character->CharacterId, $MasteryId, $Value);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Checks if a character is online
	 *
	 * @param $Character
	 *   The character entity, must have it's characterId property set
	 *
	 * @return boolean
	 *   Whether the character is online or not
	 */
	public function IsOnline(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_ISONLINE);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Count);

		$Query->Fetch();

		if($Count)
			return true;
		else
			return false;
	}
}
?>