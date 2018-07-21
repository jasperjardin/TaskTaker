    /**
     * initialize Backbone
     */
    var tasks = new Tasks();
    var tasksView = new TasksView( { collection: tasks } );
    var idle_time = 500; // 5 Seconds.

    var tasksPagination = new TasksPagination();
    var tasksPaginationView = new TasksPaginationView(
        { collection: tasksPagination }
    );

    var taskLastPagination = new TaskLastPagination();
    var tasksLastPaginationView = new TasksLastPaginationView(
        { collection: taskLastPagination }
    );

    $( '.item-list' ).append('<span class="loading"></span>');

    setTimeout(function(){
        tasks.fetch();
        tasksPagination.fetch();
    }, idle_time);

    $( document ).on( 'click', '.pagination-link', function() {
        var tasks_url = tasktaker_tasks_url + "?page=" + tasktaker_page_num;
        tasks.url = tasks_url;
        tasksPagination.url = tasks_url;
        tasks.fetch();
        tasksPagination.fetch();
    });
