
    function reloadTasks() {
        last_pagination = getLastArray( tasksPagination ).attributes.page;
        tasktaker_last_page_url   = tasktaker_tasks_url + "?page=" + last_pagination;
        tasks.url = tasktaker_last_page_url;
        tasksPagination.url = tasktaker_last_page_url;
        tasks.fetch();
        tasksPagination.fetch();
    }

    function getLastArray( array ) {
        if ( typeof array === 'object' || typeof array === 'array' ) {
            return array.slice(-1)[0];
        }
    }
