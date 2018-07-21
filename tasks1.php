<?php
$db = new PDO("mysql:host=localhost;dbname=tasks", "root", "mysql" );
// $db = new PDO("mysql:host=localhost;dbname=tasks_test", "root", "mysql" );

$data = json_decode( file_get_contents( 'php://input' ) );

if ( $_SERVER[ 'REQUEST_METHOD' ] == "GET" ) {
    $statement = $db->query( 'SELECT * FROM tasks' );
    $statement->setFetchMode( PDO::FETCH_ASSOC );

    $fetch_all = array();
    $fetch_all['tasks'] = $statement->fetchAll();

    if( empty( $fetch_all['tasks'] ) ) {
        $fetch_all['tasks'] = array(
            'error' => 'There are no task to display.',
        );
    }

    echo json_encode( $fetch_all );
}
if ( $_SERVER[ 'REQUEST_METHOD' ] == "POST" ) {
    $sql   = "INSERT INTO tasks (title, description) values (:title, :description)";
    $query = $db->prepare( $sql );
    $query->execute(
        array(
            ":title"       => filter_var( $data->title, FILTER_SANITIZE_STRING ),
            ":description" => filter_var( $data->description, FILTER_SANITIZE_STRING ),
        )
    );
    $result[ 'id' ] = $db->lastInsertId();
    echo json_encode( $result );
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == "PUT" ) {
    $sql   = "UPDATE tasks SET title = :title, status = :status WHERE id = :id";
    $query = $db->prepare( $sql );
    $query->execute(
        array(
            ":title"   => filter_var( $data->title, FILTER_SANITIZE_STRING ),
            ":status"  => filter_var( $data->status, FILTER_VALIDATE_INT ),
            ":id"      => $data->id
        )
    );
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == "DELETE" ) {
    $sql   = "DELETE FROM tasks WHERE id = :id";
    $query = $db->prepare( $sql );
    $query->execute( array( ":id"=>$_GET[ 'id' ] ) );
}

$database = 'my_database';
$pdo = new PDO("mysql:host=localhost;dbname=". $database, "root", "mysql" );

$sql_db    = "CREATE DATABASE IF NOT EXISTS ". $database;
$sql_table = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    status INT(2),
    position INT(255)
)";
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->query( $sql_db );
$pdo->query( $sql_table );
