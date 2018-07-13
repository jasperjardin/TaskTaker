<?php
namespace Tasks\Database;

use \PDO;
use Tasks\Utility\Helpers as Helpers;

/**
 * Class which handles the database interactions.
 *
 * @category Tasks\Database\Connection
 * @package  Tasks
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
class Connection
{
    private $host     = TASKTAKER_DB_HOST;
    private $database = TASKTAKER_DB_NAME;
    private $charset  = TASKTAKER_DB_CHARSET;
    private $username = TASKTAKER_DB_USER;
    private $password = TASKTAKER_DB_PASSWORD;

    public function __construct()
    {
        $this->initilizeNewConnection();
    }

    protected function setConnection( $host, $database, $charset, $username, $password )
    {
        $helpers  = new Helpers();
        $is_empty = $helpers->isEmpty( $host, $database, $charset, $username, $password );

        if ( ! $is_empty ) {
            $this->host     = $host;
            $this->database = $database;
            $this->charset  = $charset;
            $this->username = $username;
            $this->password = $password;
        } else {
            echo 'Requires to have valid Database parameter (Host, Database Name, Charset, Username, Password ).';
        }
    }

    protected function setUsername($username)
    {
    	$this->username = $username;
    }

    protected function setPassword($password)
    {
    	$this->password = $password;
    }

    public function getConnection()
    {
    	return "mysql:dbname=$this->database;host=$this->host;charset=$this->charset";
	}

    protected function getUsername()
    {
    	return $this->username;
    }

    protected function getPassword()
    {
    	return $this->password;
    }

    public function initilizeNewConnection()
    {
        $options = array(
            PDO::ATTR_PERSISTENT       => true,
            PDO::ATTR_EMULATE_PREPARES => true,
            PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ERRMODE          => PDO::ERRMODE_WARNING
        );

        try{

            $initilize_connection = new PDO( $this->getConnection(), $this->getUsername(), $this->getPassword(), $options );

            return $initilize_connection;

        } catch( PDOException $e ) {
            return $e->getMessage();
        }
    }
    public function initilizeNewDatabase()
    {
        try{
            $initilize_database = new PDO( "mysql:host=$this->host", $this->getUsername(), $this->getPassword() );
            $initilize_database->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            return $initilize_database;
        } catch( PDOException $e ) {
            return $e->getMessage();
        }
    }

}
