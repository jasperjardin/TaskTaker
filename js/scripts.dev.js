jQuery(document).ready(function($) {
	'use strict'
	$(window).load( function() {

    /**
     * Define Variables
     */
    var tasktaker_page_num      = 1;
    var tasktaker_tasks_url     = 'RestAPI/tasks.php';
    var tasktaker_last_page_url = '';
    var last_pagination         = '';
    var last_page               = '';

    /**
     * Start of Backbone Model
     */
    var Task = Backbone.Model.extend({
        url: function (){
            return this.id ? tasktaker_tasks_url + "?id=" + this.id : tasktaker_tasks_url;
        },
        defaults: {
            id: this.id,
            title: this.title,
            description: this.description,
            status: 0,
            position: this.position,
            error: this.error,
        }
    });

    var TaskPagination = Backbone.Model.extend({
        url: function (){
            return tasktaker_page_num ? tasktaker_tasks_url + "?page=" + tasktaker_page_num : tasktaker_tasks_url;
        },
        defaults: {
            page: tasktaker_page_num,
            classlist: this.classlist,
            link:  this.link,
            title: this.title,
            label: this.label,
        }
    });

    var TaskLastPagination = Backbone.Model.extend({
        url: function (){
            return tasktaker_page_num ? tasktaker_tasks_url + "?page=" + tasktaker_page_num : tasktaker_tasks_url;
        },
        defaults: {
            page: this.page,
        }
    });

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

    /**
     * Start of Backbone Router
     */

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

    /**
     * Functionalities and Events for Adding Task.
     */
    $( "#new-task-btn" ).on( 'click', function(e) {
        e.preventDefault();
        createNewTask();
    });

    $( '#new-task-item' ).on( 'keypress', function(e) {
        if ( e.keyCode != 13 ) {
            return;
        }
        createNewTask();
    });

    function createNewTask() {
        var title             = $( '#new-task-item' ).val();
        var desc              = $( '#new-task-description' ).val();
        var task              = new Task;
        var section           = $('.task-title-field-section');
        var notification      = section.find('.notification-ui');

        if( title  !== "" ) {
            task.set({
                'title': title,
                'description': desc
            });
            task.save({
                success: function ( collection, response ) {
                    notification.html('<p class="message error">Shit</p>').fadeIn(500).fadeOut(2000);
                }
            });

            tasksPagination.fetch({
                success: function ( collection, response ) {
                    reloadTasks();
                }
            });
            tasks.add( task );

            $( '#new-task-item' ).val('');
            $( '#new-task-description' ).val('');
            notification.html('<p class="message success">You had successfully added a task.</p>').fadeIn(500).fadeOut(2000);
            $( '#tasks-list' ).find('.task-list-empty').remove();
        } else {
            notification.html('<p class="message error">Task has no title, the field requires a title.</p>').fadeIn(500).fadeOut(2000);
        }
    }

    /**
     * Functionalities and Events for Editing Task.
     */
    $( document ).on( 'click', '.edit-task', function(e) {
        e.preventDefault();

        var _this      = $( this );
        var icon       = $( this ).find( '.task-icon' );
        var edit_field = _this.parents('.task-item').find('.task-edit');
        var data_id    = edit_field.attr('task-id');
        var data_value = edit_field.text();
        var task       = new Task;

        if ( edit_field.hasClass( 'update-task' ) ) {
            icon.text( 'create' );
            _this.attr( 'data-label', 'Edit' );
            _this.removeClass( 'save-changes' );
            edit_field.removeClass( 'update-task' );
            edit_field.attr( 'contenteditable', 'false' );
        } else {
            icon.text( 'check' );
            _this.attr( 'data-label', 'Update' );
            _this.addClass( 'save-changes' );
            edit_field.addClass( 'update-task' );
            edit_field.attr( 'contenteditable', 'true' );
            edit_field.focus();
        }
    });

    $( document ).on( 'click', '.update-task', function(e) {
        e.preventDefault();
    });

    $( document ).on( 'click', '.task-status-checkbox', function(e) {
        var is_checked = $( this ).attr('checked');
        if ( 'checked' == is_checked ) {
            $( this ).parents('.task-item').addClass( 'completed' );
        } else {
            $( this ).parents('.task-item').removeClass( 'completed' );
        }
    });

    /**
     * Functionalities and Events for Deleting Task.
     */
     $( document ).on( 'click', '.delete-task', function() {
         tasksPagination.fetch({
             success: function ( collection, response ) {
                 reloadTasks();
             }
         });
     });

    /**
     * Functionalities and Events for going back to task list.
     */
    $( document ).on( 'click', '#back-to-task-list', function(e) {
        e.preventDefault();
        $( "#task-display-handler" ).html('').hide();
        $( "#task-list-handler" ).show();
    });

    /**
     * Functionalities and Events for Sorting Task.
     */
    $( function() {

        $( "#tasks-list" ).sortable({
            start: function(e, ui) {
                // creates a temporary attribute on the element with the old index
            },
            axis: 'y',
            stop: function(event, ui) {
                $.each( $( "#tasks-list li" ), function( index, value ) {
                  $(this).attr('data-position', index);
                });
            },
            update: function(e, ui) {
                console.log(e);
                // gets the new and old index then removes the temporary attribute
                var newIndex = ui.item.index();
                var oldIndex = $(ui.item).attr('data-position');
            }
        });
        $( "#tasks-list" ).disableSelection();
    } );



     $(document).click(function(event){
        if ( $( event.target ).closest( ".edit-task" ).length ) {
            // console.log( event );
            // console.log( event.target.getAttributeNode('data')  );
            // console.log( event.currentTarget.attributesz);
            // console.log( event.currentTarget );
            // console.log( event.target );
            // console.log( event.target.nodeName );
        }
        if ( ! $( event.target ).closest( ".edit-task" ).length ) {
        }
    });


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

    }); // end $(window).load();
}); // end jQuery(document).ready();
