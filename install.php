<?php
include_once( dirname( __FILE__ ) . '/loader.php');
include_once( TASKS_TAKER_PATH . 'classes/Installer/DatabaseInstaller.php');

$conn = new Tasks\Installer\DatabaseInstaller();

$conn->renderDatabase();
