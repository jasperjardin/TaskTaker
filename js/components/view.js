    /**
     * Start of Backbone View
     */

    // Tasks View
    var TaskView = Backbone.View.extend({
        tagName: 'li',
        attributes: function() {
            return {
                "data-position": this.model.get( 'position' )
            }
        },
        className: function() {
            var the_status = this.model.get( 'status' );
            var the_error  = this.model.get( 'error' );
            var elem_class = 'task-item';

            if ( 1 == the_status ) {
                elem_class = elem_class + ' completed';
            }
            if ( typeof the_error != "undefined") {
                elem_class = elem_class + ' task-list-empty';
            }

            return elem_class;
        },
        events: {
            'click .task-status-checkbox' : 'taskUpdateStatus',
            'click .open-task'            : 'openTask',
            'click .save-changes'         : 'taskUpdateTitle',
            'click .delete-task'          : 'taskDestroy',
        },

        openTask: function open_task(e) {
            e.preventDefault();
            $( "#task-display-handler" ).show();
            $( "#task-list-handler" ).hide();
            $( "#task-display-handler" ).html( this.renderSingle() );
        },

        taskUpdateStatus: function status(e) {
            this.model.set( 'status', this.model.get( 'status' ) == 0 ? 1 : 0 );
            Backbone.sync( "update", this.model );
        },

        taskUpdateTitle: function update(e) {
            e.preventDefault();
            var task_title = this.$el.find('.task-edit').text();
            this.model.set( 'title', task_title );
            Backbone.sync( "update", this.model );
        },

        taskDestroy: function destroy(e) {
            e.preventDefault();
            this.model.destroy();
            Backbone.sync( "delete", this.model );
        },

        template: _.template($('#tasks-template').html()),

        singleTemplate: _.template($('#task-template').html()),

        render: function(){
            return this.$el.html(this.template(this.model.attributes));
        },

        renderSingle: function(){
            return this.singleTemplate(this.model.attributes);
        }
    });
    var TasksView = Backbone.View.extend({
        initialize: function() {
            this.collection.on( 'add remove', this.render, this );
            this.collection.on( 'remove', this.remove, this );
        },
        tagName: 'ul',
        render:function () {
            $( "#tasks-list" ).children().detach();
            $( "#tasks-list" ).append(
                this.collection.map(function(task){
                    return new TaskView( {model: task} ).render();
                })
            );
        }
    });

    // Tasks Pagination View
    var TaskPaginationView = Backbone.View.extend({
        tagName: 'li',
        className: function() {
            var the_class = this.model.get( 'classlist' );
            return the_class;
        },
        events: {
            'click .pagination-link' : 'fetchData',
        },

        fetchData: function fetchData(e) {
            e.preventDefault();
            tasktaker_page_num = this.model.get( 'page' );
        },

        template: _.template($('#pagination-template').html()),

        render: function(){
            var model_attr = this.model.attributes;
            return this.$el.html(this.template(model_attr));
        },
    });
    var TasksPaginationView = Backbone.View.extend({
        initialize: function() {
            this.collection.on( 'add remove', this.render, this );
            this.collection.on( 'remove', this.remove, this );
        },
        tagName: 'ul',
        render:function () {
            $( "#tasks-pagination" ).children().detach();
            $( "#tasks-pagination" ).append(
                this.collection.map(function( tasksPagination ){
                    return new TaskPaginationView( {
                        model: tasksPagination
                    } ).render();
                })
            );
        }
    });

    var TasksLastPaginationView = Backbone.View.extend({
        initialize: function() {
            this.collection.on( 'add remove', this.render, this );
            this.collection.on( 'remove', this.remove, this );
        },
        render:function () {
            this.collection.map(function( tasksLastPagination ){
                return new TaskPaginationView( {
                    model: tasksLastPagination
                } ).render();
            })
        }
    });
