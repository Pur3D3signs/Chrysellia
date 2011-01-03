<?php

namespace Database;


/**
 * Abstract Database class
 */
abstract class Database
{
	/**
	 * The connection object, stored a reference to mysqli connection
	 *
	 * @var Connection
	 */
	public $Connection;

	/**
	 * Reference to object that contains Account related queries
	 *
	 * @var Accounts
	 */
	public $Accounts;

	/**
	 * Reference to object that contains Character related queries
	 *
	 * @var Characters
	 */
	public $Characters;

	/**
	 * Reference to object that contains Session related queries
	 *
	 * @var Sessions
	 */
	public $Sessions;

	/**
	 * Reference to object that contains Chat related queries
	 *
	 * @var Chat
	 */
	public $Chat;

	/**
	 * Reference to object that contains Race related queries
	 *
	 * @var Races
	 */
	public $Races;

	/**
	 * Reference to object that contains Map related queries
	 *
	 * @var Maps
	 */
	public $Maps;

	/**
	 * Reference to object that contains Item related queries
	 *
	 * @var Items
	 */
	public $Items;

	/**
	 * Constructor for the abstract Database class
	 *
	 * Throws an exception when connection fails
	 *
	 * @param $Host
	 *   The hostname/ip address of the database server
	 *
	 * @param $Port
	 *   The port on which the database server is listening
	 *
	 * @param $UserName
	 *   A UserName which has access to the database we'll be using.
	 *
	 * @param $Password
	 *   The Password for the UserName provided
	 *
	 * @param $Database
	 *   The Database which contains the Chrysellia tables
	 *
	 * @throws Exception
	 */
	abstract public function __construct($Host, $Port, $UserName, $Password, $Database);

	/**
	 * Starts a MySQL Transaction
	 *
	 * Causes queries to not be directly applied to the database.
	 */
	abstract public function startTransaction();

	/**
	 * Commits a MySQL Transaction
	 *
	 * Causes queries submitted after a startTransaction() call to be applied to the database.
	 * Also causes connection to return to autocommit mode.
	 */
	abstract public function commitTransaction();

	/**
	 * Rolls back a MySQL database to before a transaction was started.
	 *
	 * Causes queries submitted after a startTransaction() call not to be applied to the database.
	 * Also causes connection to return to autocommit mode.
	 */
	abstract public function rollbackTransaction();
}

?>