    /**
     * Functionalities and Events for going back to task list.
     */
    $( document ).on( 'click', '#back-to-task-list', function(e) {
        e.preventDefault();
        $( "#task-display-handler" ).html('').hide();
        $( "#task-list-handler" ).show();
    });
