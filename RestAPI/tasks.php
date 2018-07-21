<?php

include_once( realpath( dirname( __FILE__ ) ) . '/../loader.php');
include_once( TASKS_TAKER_PATH . 'classes/Objects/Tasks.php');

header("Content-Type: text/json");

$conn  = new Tasks\Database\Connection();
$tasks = new Tasks\Objects\Tasks($conn);
$data = json_decode( file_get_contents( 'php://input' ) );

if ( $_SERVER[ 'REQUEST_METHOD' ] == "GET" ) {
    $page_number = filter_input( INPUT_GET, 'page', FILTER_VALIDATE_INT );
    $items_per_page = 8;

    if ( empty( $page_number ) ) {
        $page_number = 1;
    }

    $pagination_args = array(
        'items_per_page' => $items_per_page,
        'page_number'    => $page_number,
        'total_items'    => $tasks->count(),
        'page_range'     => 2,
    );

    $results = $tasks->readALL( $page_number, $items_per_page );
    $results['pagination'] = $tasks->paginateArray( $pagination_args );
    $results['last_pagination'] = $tasks->getLastPagination( $pagination_args );
    echo json_encode( $results, true );
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == "POST" ) {
    $result = array();
    $tasks->title       = $data->title;
    $tasks->description = $data->description;
    if ( $tasks->create() ) {
        $result['response'] = array(
            'id'      => $tasks->getLastInsertId(),
            'success' => "Task created!",
        );
        echo json_encode( $result );
    }
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == "PUT" ) {
    $result = array();
    $tasks->id          = $data->id;
    $tasks->title       = $data->title;
    $tasks->description = $data->description;
    $tasks->status      = $data->status;
    $tasks->position    = $data->position;

    if ( $tasks->update() ) {
        $result['response'] = array(
            'success' => "Task updated!",
        );
        echo json_encode( $result );
    }
}

if ( $_SERVER[ 'REQUEST_METHOD' ] == "DELETE" ) {
    $tasks->id = filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT );

    if( $tasks->delete() ){
        $result['response'] = array(
            'success' => "Task deleted!",
        );
        echo json_encode( $result );
    }
}
