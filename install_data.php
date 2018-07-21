<?php
include_once( dirname( __FILE__ ) . '/loader.php');
include_once( TASKS_TAKER_PATH . 'classes/Objects/Tasks.php');

$conn  = new Tasks\Database\Connection();
// How to use Class handler
$handler = new Tasks\CRUD\DataHandler($conn);

//Insert multiple records using a Transaction.
$handler->beginTransaction();

$handler->query('INSERT INTO tasks (id, title, description) VALUES (:id, :title, :description)');
$handler->bind( ':id', 1 );
$handler->bind( ':title', 'Task 01' );
$handler->bind( ':description', 'Wake up 7am!' );
$handler->execute();

$handler->bind( ':id', 2 );
$handler->bind( ':title', 'Task 02' );
$handler->bind( ':description', 'Strech your muscles and be firm.' );
$handler->execute();

$handler->bind( ':id', 3 );
$handler->bind( ':title', 'Task 03' );
$handler->bind( ':description', 'Fix my bed.' );
$handler->execute();

$handler->bind( ':id', 4 );
$handler->bind( ':title', 'Task 04' );
$handler->bind( ':description', 'Go to the bathroom.' );
$handler->execute();

$handler->bind( ':id', 5 );
$handler->bind( ':title', 'Task 05' );
$handler->bind( ':description', 'Brush my teeth.' );
$handler->execute();

$handler->bind( ':id', 6 );
$handler->bind( ':title', 'Task 06' );
$handler->bind( ':description', 'Take a bath.' );
$handler->execute();

$handler->bind( ':id', 7 );
$handler->bind( ':title', 'Task 07' );
$handler->bind( ':description', 'Scrub my body.' );
$handler->execute();

$handler->bind( ':id', 8 );
$handler->bind( ':title', 'Task 08' );
$handler->bind( ':description', 'Change cloths.' );
$handler->execute();

$handler->bind( ':id', 9 );
$handler->bind( ':title', 'Task 09' );
$handler->bind( ':description', 'Cook breakfast.' );
$handler->execute();

$handler->bind( ':id', 10 );
$handler->bind( ':title', 'Task 10' );
$handler->bind( ':description', 'Eat breakfast.' );
$handler->execute();

$handler->bind( ':id', 11 );
$handler->bind( ':title', 'Task 11' );
$handler->bind( ':description', 'Walk my dog.' );
$handler->execute();

$handler->bind( ':id', 12 );
$handler->bind( ':title', 'Task 12' );
$handler->bind( ':description', 'Say hello to the neighbors.' );
$handler->execute();

$handler->bind( ':id', 13 );
$handler->bind( ':title', 'Task 13' );
$handler->bind( ':description', 'Read a book.' );
$handler->execute();

$handler->bind( ':id', 14 );
$handler->bind( ':title', 'Task 14' );
$handler->bind( ':description', 'Watch TV.' );
$handler->execute();

$handler->bind( ':id', 15 );
$handler->bind( ':title', 'Task 15' );
$handler->bind( ':description', 'Do some laundry.' );
$handler->execute();

$handler->bind( ':id', 16 );
$handler->bind( ':title', 'Task 16' );
$handler->bind( ':description', 'Yahooo.' );
$handler->execute();

$handler->bind( ':id', 17 );
$handler->bind( ':title', 'Task 17' );
$handler->bind( ':description', 'Pass the Exam.' );
$handler->execute();

$handler->bind( ':id', 18 );
$handler->bind( ':title', 'Task 18' );
$handler->bind( ':description', 'Check quizes.' );
$handler->execute();

$handler->bind( ':id', 19 );
$handler->bind( ':title', 'Task 19' );
$handler->bind( ':description', 'Record my voice.' );
$handler->execute();

$handler->bind( ':id', 20 );
$handler->bind( ':title', 'Task 20' );
$handler->bind( ':description', 'Hello Dolly.' );
$handler->execute();

// echo 'Last inserted ID: '. $databas  e->lastInsertId() .'<br>';

$handler->endTransaction();
