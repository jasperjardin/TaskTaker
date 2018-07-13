<?php
namespace Tasks\CRUD\AbstractTemplate;

/**
 * Abstract Class for Create, Read, Update and Delete.
 *
 * @category Tasks\CRUD\Abstract\DataHandler
 * @package  TaskTaker
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
abstract class DataHandler
{
    abstract protected function query($query);
}
