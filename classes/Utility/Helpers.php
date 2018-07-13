<?php
namespace Tasks\Utility;

/**
 * Helper Class
 *
 * @category Tasks\Utilities\Helpers
 * @package  Tasks
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
class Helpers
{
    public function isEmpty() {
        $args = func_get_args();

        foreach( $args as $arg ) {
            if( empty( $arg ) ) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    public function sanitize_string( $value = '' ) {
        $filtered_value = '';
        $filtered_value = filter_var( $value, FILTER_SANITIZE_STRING );
        return $filtered_value;
    }

    public function sanitize_int( $value = '' ) {
        $filtered_value = '';
        $filtered_value = filter_var( $value, FILTER_VALIDATE_INT );
        return $filtered_value;
    }
}
