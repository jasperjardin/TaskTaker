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
