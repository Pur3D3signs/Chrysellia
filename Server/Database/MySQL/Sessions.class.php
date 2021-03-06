<?php

namespace Database\MySQL;

define('SQL_GETSESSION', 'SELECT `data` FROM `sessions` WHERE `sessionId`=?');
define('SQL_REPLACESESSION', 'INSERT INTO `sessions` (`sessionId`, `accountId`, `characterId`, `data`, `lastUsedOn`) VALUES (?, ?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE `accountId`=?, `characterId`=?, `data`=?, `lastUsedOn`=NOW()');
define('SQL_DELETESESSION', 'DELETE FROM `sessions` WHERE `sessionId`=?');
define('SQL_CLEANSESSIONS', 'DELETE FROM `sessions` WHERE `lastUsedOn` < (NOW() - INTERVAL ? SECOND)');
define('SQL_GETONLINE', 'SELECT count(*) FROM `sessions` WHERE `lastUsedOn` > (NOW() - INTERVAL 360 SECOND)');

/**
 * Contains properties and methods related to querying our sessions table and relations
 */
class Sessions extends \Database\Sessions
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Session Queries class
	 *
	 * Contains all queries for loading Sessions from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Gets a session from the database
	 *
	 * @param $Id
	 *   The session identifier
	 *
	 * @return String
	 *   The encoded session data
	 */
	public function Load($Id)
	{
		
		if($Query = $this->Database->Connection->prepare(SQL_GETSESSION))
		{
			$Query->bind_param('s', $Id);

			$Query->Execute();

			$Query->bind_result($Data);

			if($Query->fetch())
				return $Data;
			else
				return '';
		}
		return '';
	}

	/**
	 * Replace a Session into the database
	 *
	 * @param $Account
	 *   The Account class that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Account object was successfully inserted or not
	 */
	public function Replace($Id, $AccountId, $CharacterId, $Data)
	{
		if($Query = $this->Database->Connection->prepare(SQL_REPLACESESSION))
		{
			$Query->bind_param('sssssss', $Id, $AccountId, $CharacterId, $Data, $AccountId, $CharacterId, $Data);

			$Query->Execute();

			if($Query->affected_rows > 0)
				return true;
			else
				return false;
		}
	}

	/**
	 * Replace a Session into the database
	 *
	 * @param $Account
	 *   The Account class that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Account object was successfully inserted or not
	 */
	public function Delete($Id)
	{
		$Query = $this->Database->Connection->prepare(SQL_DELETESESSION);
		$Query->bind_param('s', $Id);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Clean the sessions table
	 *
	 *
	 * @return Boolean
	 *   Whether the cleaning was successful or not.
	 */
	public function Clean($Seconds)
	{
		$Query = $this->Database->Connection->prepare(SQL_CLEANSESSIONS);
		$Query->bind_param('s', $Seconds);
		$Query->Execute();

		return true;
	}

	/**
	 * Checks how many active sessions there are
	 *
	 * @return int
	 *   The number of onlines
	 */
	public function GetOnline()
	{
		$Query = $this->Database->Connection->prepare(SQL_GETONLINE);
		$Query->Execute();
		$Query->bind_result($Count);
		$Query->Fetch();
		return $Count;
	}
}
?>