<?php
include_once( dirname( __FILE__ ) . '/loader.php');
include_once( TASKS_TAKER_PATH . 'classes/Objects/Tasks.php');

$conn  = new Tasks\Database\Connection();
$tasks = new Tasks\Objects\Tasks($conn);

$tasks->id          = 176;
$tasks->title       = 'The New Title Shit123';
$tasks->description = 'The New Description';
$tasks->status      = 1;
$tasks->position    = 1;

var_dump($tasks->update());

if( $tasks->update() ){
    echo "Object was updated.";
}

$tasks->title       = 'Task 177';
$tasks->description = 'DayBreaker';
$tasks->status      = 1;
$tasks->position    = 177;

// if( $tasks->create() ){
//     echo "Object was created.";
// }

$tasks->id          = 175;
if( $tasks->delete() ){
    echo "Object was deleted.";
}

echo "<pre>";
    // print_r($tasks->readALL(2));
    print_r($tasks->read(175));
echo "</pre>";

echo md5('admin123') . '<br> $P$BMZpPuebY1Jl9qIci.2bT.F513IjMp0<br>';

// var_dump( $conn->readAll( 'SELECT * FROM tasks ORDER BY id DESC' ) );

// How to use Class handler
$handler = new Tasks\CRUD\DataHandler($conn);
// Select a single row
// $conn->query('SELECT title, description, status FROM tasks WHERE title = :title');
$handler->query('SELECT * FROM tasks');

$handler->bind(':title', 'task 01');

// $row = $conn->resultset();
$row = $handler->single();

echo "<pre>";
    // print_r($row);
echo "</pre>";

/*

// Instantiate database.
$database = new Tasks\CRUD\DataHandler();

// Insert a new record.
$database->query('INSERT INTO tasks (title, description, status, position) VALUES (:title, :description, :status, :position)');

$database->bind(':title', 'Newly Added PDO Task 01');
$database->bind(':description', 'This is a PDO task');
$database->bind(':status', '1');
$database->bind(':position', '100');

// $database->execute();
// echo 'Last inserted ID: '. $database->lastInsertId() .'<br>';


//Insert multiple records using a Transaction.
$database->beginTransaction();

$database->query('INSERT INTO tasks (title, description, status, position) VALUES (:title, :description, :status, :position)');
$database->bind(':title', 'Newly Added PDO Task 02');
$database->bind(':description', 'This is a PDO task');
$database->bind(':status', '0');
$database->bind(':position', '101');

// $database->execute();

$database->bind(':title', 'Newly Added PDO Task 03');
$database->bind(':description', 'This is a PDO task');
$database->bind(':status', '1');
$database->bind(':position', '102');

// $database->execute();

// echo 'Last inserted ID: '. $databas  e->lastInsertId() .'<br>';

$database->endTransaction();


// Select a single row
$database->query('SELECT title, description, status, position FROM tasks WHERE title = :title');

$database->bind(':title', 'Newly Added PDO Task 03');

$row = $database->single();

echo "<pre>";
    print_r($row);
echo "</pre>";


// Select multiple rows
$database->query('SELECT title, description, status, position FROM tasks WHERE title = :title');

$database->bind(':title', 'Newly Added PDO Task 01');

$rows = $database->resultset();

echo "<pre>";
    print_r($rows);
echo "</pre>";

echo $database->rowCount();
echo '<br>';


// Select multiple rows
$database->query('SELECT id, title, description, status, position FROM tasks WHERE title = :title AND status = :status');

$args = array(
    '1' => array(
        'param' => ':title',
        'val' => 'Newly Added PDO Task 01'
     ),
    '2' => array(
        'param' => ':status',
        'val' => '1'
     )
);
foreach ($args as $arg) {
    $database->bind( $arg['param'], $arg['val'] );
}
$rows = $database->resultset();
$rowTotal = $database->rowCount();


foreach ($rows as $row) {
    echo $row["title"] . "-" . $row["status"] ."<br/>";
}

*/
