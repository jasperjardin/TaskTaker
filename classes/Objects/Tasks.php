<?php
namespace Tasks\Objects;

include_once( TASKS_TAKER_PATH . 'classes/Navigations/Pagination.php');

use \PDO;

use Tasks\CRUD\DataHandler as DataHandler;

use Tasks\Navigations\Pagination as Pagination;

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
    protected $last_insert_id;
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

        if ( $statement->execute() ) {
            $this->setLastInsertId( $statement->lastInsertId() );
            $statement->endTransaction();
            return true;
        }

        return false;
    }

    public function readAll( $page_num = '', $items_per_page = '', $order_by = 'id', $order = 'ASC' )
    {
        $statement = '';
        $offset    = '';
        $fetch_all = array();
        $query     = "SELECT * FROM {$this->table}";

        if ( ! is_numeric( $items_per_page ) ) {
            $items_per_page = TASKTAKER_TASKS_PER_PAGE;
        }

        $query .= ' ORDER BY ' . $order_by . ' ' . $order;

        if ( is_numeric( $page_num ) && 0 !== $page_num ) {
            $offset = ( $items_per_page * $page_num ) - $items_per_page;
            $query .= " LIMIT ". $offset .", " . $items_per_page;
        }


        if ( 0 !== $page_num ) {
            $statement = $this->handler;
            $statement->query( $query );
            $fetch_all['tasks'] = $statement->resultset();
        }

        if ( empty( $fetch_all['tasks'] ) ) {
            $fetch_all['tasks'] = array(
                'error' => 'There are no task to display.',
            );
        }

        return $fetch_all;
    }

    public function count()
    {
        $statement = $this->handler;
        $query     = "SELECT * FROM tasks";

        $statement->query( $query );
        $statement->resultset();

        return $statement->rowCount();
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

        if ( $statement->execute() ) {
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

        if ( $statement->execute() ) {
            $statement->endTransaction();
            return true;
        }

        return false;
    }

    private function setLastInsertId( $last_insert_id = '' )
    {
        if ( is_numeric( $last_insert_id ) ) {
            $this->last_insert_id = $last_insert_id;
        }
        return;
    }

    public function getLastInsertId()
    {
        return $this->last_insert_id;
    }

    private function getPaginationArgs( $set_args = array() )
    {
        $actual_link = (
            isset(
                $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on'
                ? "https" : "http"
            ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $default_args = array(
            'items_per_page' => 5,
            'page_number'    => 1,
            'total_items'    => 13,
            'page_range'     => 5,
            'page_url'       => $actual_link,
        );

        $args = array_merge( $default_args, $set_args );

        $pagination = new Pagination();
        $pagination->setPageURL( $args[ 'page_url' ] );
        $pagination->setItemsPerPage( $args[ 'items_per_page' ] );
        $pagination->setPageNumber( $args[ 'page_number' ] );
        $pagination->setTotalItems( $args[ 'total_items' ] );
        $pagination->setPageRange( $args[ 'page_range' ] );

        return $pagination;
    }

    public function paginate( $set_args = array() )
    {
        $pagination = $this->getPaginationArgs( $set_args );

        return $pagination->paginate();
    }

    public function paginateArray( $set_args = array() )
    {
        $pagination = $this->getPaginationArgs( $set_args );

        return $pagination->paginateArray();
    }

    public function getLastPagination( $set_args = array() )
    {
        $pagination = $this->getPaginationArgs( $set_args );
        $last_pagination = array(
            'page' => $pagination->getLastPagination(),
        );

        return $last_pagination;
    }
}
