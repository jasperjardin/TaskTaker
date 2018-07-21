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
