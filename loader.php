<?php
define( 'TASKS_TAKER_PATH', realpath( dirname( __FILE__ ) ) . '/' );
include_once( TASKS_TAKER_PATH . 'config/config.php');
include_once( TASKS_TAKER_PATH . 'classes/Utility/Helpers.php');
include_once( TASKS_TAKER_PATH . 'template-tags/template-tags.php');
include_once( TASKS_TAKER_PATH . 'classes/Database/Connection.php');
include_once( TASKS_TAKER_PATH . 'classes/CRUD/DataHandler.php');
