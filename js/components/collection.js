    /**
     * Start of Backbone Collection
     */
    var Tasks = Backbone.Collection.extend({
        model: Task,
        url: tasktaker_tasks_url,
        parse: function( data ) {
            return data.tasks;
        },
    });

    var TasksPagination = Backbone.Collection.extend({
        model: TaskPagination,
        url: tasktaker_tasks_url,
        parse: function( data ) {
            last_page = data.last_pagination;
            return data.pagination;
        },
    });

    var TasksLastPagination = Backbone.Collection.extend({
        model: TaskLastPagination,
        url: tasktaker_tasks_url,
        parse: function( data ) {
            return data.last_pagination;
        },
    });
