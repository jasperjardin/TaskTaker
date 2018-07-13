<?php
namespace Tasks\CRUD;

include_once( TASKS_TAKER_PATH . 'classes/CRUD/Abstract/DataHandler.php');

use \PDO;
use Tasks\CRUD\AbstractTemplate\DataHandler as AbstractDataHandler;

/**
 * Class for Create, Read, Update and Delete.
 *
 * @category Tasks\CRUD\Generator
 * @package  Tasks
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
class DataHandler extends AbstractDataHandler
{
    // database connection and table name
    protected $connection;
    protected $stmt;

    /**
     * Initialize database connection for PDO.
     *
     * @param object $connection Requires you to pass the Tasks\Database\Connection() class.
     * @return void
     */
    public function __construct( $connection = '' )
    {
        // Requires you to pass the Tasks\Database\Connection() class
        $this->connection = $connection->initilizeNewConnection();
        return;
    }

    public function query($query){
        $this->stmt = $this->connection->prepare($query);
    }

    public function bind($param, $value, $type = null){
        if (is_null($type)) {
        	switch (true) {
        		case is_int($value):
        			$type = PDO::PARAM_INT;
        			break;
        		case is_bool($value):
        			$type = PDO::PARAM_BOOL;
        			break;
        		case is_null($value):
        			$type = PDO::PARAM_NULL;
        			break;
        		default:
        			$type = PDO::PARAM_STR;
        	}
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }

    public function lastInsertId(){
        return $this->connection->lastInsertId();
    }

    public function beginTransaction(){
        return $this->connection->beginTransaction();
    }

    public function endTransaction(){
        return $this->connection->commit();
    }

    public function cancelTransaction(){
        return $this->connection->rollBack();
    }

    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
}
