<?php
namespace Tasks\Objects;

use \PDO;

use Tasks\CRUD\DataHandler as DataHandler;

/**
 * Class for Create, Read, Update and Delete.
 *
 * @category Tasks\Objects\Tasks
 * @package  Tasks
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
class Tasks
{
    // object properties
    protected $handler;
    protected $table = 'tasks';
    public $id;
    public $title;
    public $description;
    public $status;
    public $position;

    public function __construct( $connection = '' )
    {
        if ( $connection ) {
            $this->handler = new DataHandler( $connection );
        }
    }

    public function create()
    {
        $query = "INSERT INTO {$this->table}
                    (title, description, status, position)
                  VALUES
                    (:title, :description, :status, :position)";

        $statement = $this->handler;

        $statement->beginTransaction();
        $statement->query( $query );

        $this->title       = filter_var( $this->title, FILTER_SANITIZE_STRING );
        $this->description = filter_var( $this->description, FILTER_SANITIZE_STRING );
        $this->status      = filter_var( $this->status, FILTER_VALIDATE_INT );
        $this->position    = filter_var( $this->position, FILTER_VALIDATE_INT );
        $this->id          = filter_var( $this->id, FILTER_VALIDATE_INT );

        $statement->bind( ':title', $this->title );
        $statement->bind( ':description', $this->description );
        $statement->bind( ':status', $this->status );
        $statement->bind( ':position', $this->position);

        if( $statement->execute() ){
            $statement->endTransaction();
            return true;
        }

        return false;
    }

    public function readAll( $page = '' )
    {
        $result = '';
        $offset = ( TASKS_PER_PAGE * $page ) - TASKS_PER_PAGE;
        $query = "SELECT * FROM {$this->table} LIMIT ". $offset .", " . TASKS_PER_PAGE;

        if ( empty( $page ) ) {
            $query = "SELECT * FROM tasks";
        }

        $statement = $this->handler;
        $statement->query( $query );
        $result = $statement->resultset();

        return $result;
    }

    public function read( $id )
    {
        $query = "SELECT
                    id,
                    title,
                    description,
                    status,
                    position
                  FROM tasks
                  WHERE id = :id
                  LIMIT 0, 1";

        $statement = $this->handler;

        $statement->query( $query );

        $statement->bind( ':id', $id );

        return $statement->single();
    }

    public function update()
    {
        $query = "UPDATE
                    {$this->table}
                  SET
                    title = :title,
                    description = :description,
                    status = :status,
                    position = :position
                  WHERE
                    id = :id";

        $statement = $this->handler;

        $statement->beginTransaction();
        $statement->query( $query );

        $this->title       = filter_var( $this->title, FILTER_SANITIZE_STRING );
        $this->description = filter_var( $this->description, FILTER_SANITIZE_STRING );
        $this->status      = filter_var( $this->status, FILTER_VALIDATE_INT );
        $this->position    = filter_var( $this->position, FILTER_VALIDATE_INT );
        $this->id          = filter_var( $this->id, FILTER_VALIDATE_INT );

        $statement->bind( ':title', $this->title );
        $statement->bind( ':description', $this->description );
        $statement->bind( ':status', $this->status );
        $statement->bind( ':position', $this->position);
        $statement->bind( ':id', $this->id );

        if( $statement->execute() ){
            $statement->endTransaction();
            return true;
        }

        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $statement = $this->handler;

        $statement->beginTransaction();

        $statement->query( $query );
        $this->id = filter_var( $this->id, FILTER_VALIDATE_INT );
        $statement->bind( ':id', $this->id );

        if( $statement->execute() ){
            $statement->endTransaction();
            return true;
        }

        return false;
    }
}
