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
