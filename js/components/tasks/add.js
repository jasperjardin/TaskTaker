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
