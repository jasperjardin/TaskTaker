<?php
namespace Tasks\Installer;

use \PDO;

use Tasks\Database\Connection as Connection;

/**
 * Class for the Database Installer
 *
 * @category Tasks\Installer\DatabaseInstaller
 * @package  Tasks
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
class DatabaseInstaller extends Connection
{
    private $new_database;

    public function __construct( $new_db = '' ) {
        $this->new_database = $new_db;

        if ( empty( $new_db ) ) {
            $this->new_database = 'Tasks';
        }
    }

    public function getDatabaseConnection()
    {
        $connection = new Connection();

        return $connection;
    }
    public function getConnection()
    {
        $connection = $this->getDatabaseConnection();
        $connection->setConnection(
            TASKTAKER_DB_HOST,
            $this->new_database,
            TASKTAKER_DB_CHARSET,
            TASKTAKER_DB_USER,
            TASKTAKER_DB_PASSWORD
        );
        return $connection;
    }

    public function getPDO()
    {
        $conn = $this->getConnection();

        $pdo = $conn->initilizeNewConnection();

        return $pdo;
    }

    public function getNewDatabasePDO()
    {
        $conn = $this->getConnection();

        $pdo = $conn->initilizeNewDatabase();

        return $pdo;
    }

    public function createDatabase()
    {
        $pdo = $this->getNewDatabasePDO();

        $pdo->query( "CREATE DATABASE IF NOT EXISTS $this->new_database" );
        $pdo->query( "use $this->new_database" );
    }

    public function createTables()
    {
        try {
            $conn = $this->getPDO();

            $conn->query( "use $this->new_database" );

            $sql = "CREATE TABLE tasks(
                        id INT(11) NOT NULL AUTO_INCREMENT,
                        title VARCHAR(255) NOT NULL,
                        description VARCHAR(255) NOT NULL,
                        status INT(1) NOT NULL,
                        position INT(255) NOT NULL,
                        PRIMARY KEY (id)
                    );";
            $conn->exec($sql);

            echo "Table -> tasks under $this->new_database was created successfully";

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function renderDatabase()
    {
        $this->createDatabase();
        $this->createTables();
    }
}
