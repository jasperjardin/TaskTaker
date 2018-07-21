<?php
namespace Tasks\Navigations;

/**
 * Class for pagination.
 *
 * @category Tasks\Navigations\Pagination
 * @package  Tasks
 * @author   Jasper Jardin <emailnotdisplayed@domain.tld>
 * @license  http://opensource.org/licenses/gpl-license.php  GNU Public License
 * @link     https://github.com/jasperjardin/tasktaker
 * @since    1.0.0
 */
class Pagination
{
    private $class = 'pagination-nav';
    private $page_url;
    private $items_per_page;
    private $page_number;
    private $total_items;
    private $page_range;

    public function setPageURL( $url = '' )
    {
        $validate_url = filter_var( $url, FILTER_VALIDATE_URL );

        if ( $validate_url ) {
            $this->page_url = $validate_url;
        }

        return;
    }

    public function setItemsPerPage( $items_per_page = '' )
    {
        if ( is_numeric( $items_per_page ) ) {
            if ( 0 == $items_per_page ) {
                $this->items_per_page = 0;
            }
            $this->items_per_page = $items_per_page;
        }
        return;
    }

    public function setPageNumber( $page_number = '' )
    {
        if ( is_numeric( $page_number ) ) {
            if ( 0 == $page_number ) {
                $this->page_number = 1;
            }
            $this->page_number = $page_number;
        }

        return;
    }

    public function setTotalItems( $total_items = '' )
    {
        if ( is_numeric( $total_items ) ) {
            if ( 0 == $total_items ) {
                $this->total_items = 0;
            }
            $this->total_items = $total_items;
        }

        return;
    }

    public function setPageRange( $page_range = '' )
    {
        if ( is_numeric( $page_range ) ) {
            if ( 0 == $page_range ) {
                $this->total_items = 0;
            }
            $this->page_range = $page_range;
        }

        return;
    }

    public function paginateArray()
    {
        $pagination          = array();
        $pagination_attr     = array();
        $filtered_pagination = array();
        $array_position      = 0;
        $last_pagination     = '';
        $items_per_page      = $this->items_per_page;
        $page_number         = $this->page_number;
        $total_items         = $this->total_items;
        $page_range          = $this->page_range;
        $page_url            = $this->page_url;

        // First page
        if( $page_number > 1 ) {
            $array_position = 0;
            $pagination_attr['page'] = $array_position;
            $pagination_attr['classlist'] = $this->class . " first";
            $pagination_attr['link']  = "{$page_url}";
            $pagination_attr['title'] = "Go to the first page.";
            $pagination_attr['label'] = "First Page";
        }

        // count all products in the database to calculate total pages
        $total_pages  = ceil( $total_items / $items_per_page );

        // display links to 'range of pages' around 'current page'
        $initial_page = $page_number - $page_range;
        $page_limit   = ( $page_number + $page_range )  + 1;

        for ( $page_index = $initial_page; $page_index < $page_limit; $page_index++ ) {

            $pagination[$array_position] = $pagination_attr;

            // be sure '$page_index is greater than 0'
            // AND 'less than or equal to the $total_pages'
            if ( ( $page_index > 0 ) && ( $page_index <= $total_pages ) ) {
                $array_position = $page_index;

                $pagination_attr['page'] = $array_position;

                // current page
                if ( $page_index == $page_number ) {
                    $pagination_attr['classlist']  = $this->class . " current";
                    $pagination_attr['link']   = "#";
                    $pagination_attr['title']  = "Current Page";
                    $pagination_attr['label']  = $page_index;
                    // not current page
                } else {
                    $pagination_attr['classlist']  = $this->class;
                    $pagination_attr['link']   = "{$page_url}?page=$page_index";
                    $pagination_attr['title']  = "View page " . $page_index;
                    $pagination_attr['label']  = $page_index;
                }
            }

            $pagination[$array_position] = $pagination_attr;
        }

        // Last page
        if( $page_number < $total_pages ) {
            $array_position = $total_pages;
            $pagination_attr['page'] = $array_position;
            $pagination_attr['classlist'] = $this->class . " last";
            $pagination_attr['link']  = "{$page_url}?page=$total_pages";
            $pagination_attr['title'] = "Go to the last page.";
            $pagination_attr['label'] = "Last Page";
            $pagination[$array_position] = $pagination_attr;
        }

        foreach ( $pagination as $page_nav => $value ) {
            if ( ! empty( $value ) ) {
                $filtered_pagination[] = $value;
            }
        }

        return $filtered_pagination;
    }

    public function paginate()
    {
        $result     = '';
        $pagination = $this->paginateArray();

        if ( ! empty( $pagination ) ) {
            $result = '<ul class="pagination-ui">';
            foreach ( $pagination as $paginate => $attr ) {
                if ( ! empty( $paginate ) ) {
                    $result .= '<li class="'. $attr[ 'classlist' ] .'">';
                    $result .= '<a href="'. $attr[ 'link' ] .'" href="'. $attr[ 'title' ] .'">';
                    $result .= $attr[ 'label' ];
                    $result .= '</a>';
                    $result .= '</li>';
                }
            }
            $result .= '</ul>';
            return $result;
        }
        return;
    }

    public function getLastPagination()
    {
        $total_pages  = ceil( $this->total_items / $this->items_per_page );
        return $total_pages;
    }
}
