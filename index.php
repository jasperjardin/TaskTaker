<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Backbone.js TaskManager</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <script src="js/json2.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/underscore.js"></script>
    <script src="js/backbone.js"></script>

    <script src="js/backbone.localStorage.js"></script>
    <script src="js/scripts.dev.js"></script>

    <!-- Templates -->
    <div class="container">
        <div id="tasks-list-container" class="row">

            <header class="content-header col-md-12">
                <h3>Tasks Manager</h3>
            </header>

            <div id="tasks-container-left" class="col-md-6">
                <div class="section-header">
                    <h4>Create task</h4>
                </div>
                <div class="content-section tasks-creation-section">
                     <div class="task-title-field-section">
                        <input id="new-task-item" name="task-title" class="text-ui" type="text" placeholder="What are the task for today?">
                        <a href="#" id="new-task-btn" class="task-action new-task task-tooltip btn-ui" data-label="Create">
                            <i class="material-icons task-icon task-icon task-icon-create">send</i>
                        </a>
                        <div class="notification-ui"></div>
                     </div>
                    <textarea id="new-task-description" name="task-description" class="textarea-ui" placeholder="Describe the task..."></textarea>
                </div>
            </div>
            <div id="tasks-container-right" class="col-md-6">
                <div class="section-display" id="task-display-handler"></div>

                <div class="section-display" id="task-list-handler">
                    <div class="section-header">
                        <h4>Tasks List</h4>
                    </div>
                    <div class="content-section tasks-list-section">
                        <ul id="tasks-list" class="item-list"></ul>
                    </div>
                    <div class="pagination-section">
                        <ul id="tasks-pagination" class="pagination-ui"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/template" id="tasks-template">
        <% if ( ! error ){ %>
            <label class="vertical-align-content checkbox-ui-wrap" for="task-checkbox-<%= id %>">
                <input type="checkbox" id="task-checkbox-<%= id %>" class="task-status-checkbox vertical-align" <% if ( status == 1){ %>checked<% } %>/>
                <span class="checkbox-ui vertical-align"></span>
                <span class="task-edit vertical-align" task-id="<%= id %>"><%= title %></span>
                <span class="item-actions vertical-align">
                    <a href="#" class="task-action open-task task-tooltip" data-label="View">
                        <i class="material-icons task-icon task-icon-open">open_in_new</i>
                    </a>
                    <a href="#" class="task-action edit-task task-tooltip" data-label="Edit">
                        <i class="material-icons task-icon task-icon-edit">create</i>
                    </a>
                    <a href="#" class="task-action delete-task task-tooltip" data-label="Delete">
                        <i class="material-icons task-icon task-icon-delete" data-icon-id="<%= id %>">clear</i>
                    </a>
                </span>
            </label>
        <% } else { %>
            <%= error %>
        <% } %>
    </script>
    <script type="text/template" id="task-template">
        <div class="section-header single-task-header">
            <h4 class="single-task-title" task-id="<%= id %>"><%= title %></h4>
            <a href="#" id="back-to-task-list" class="btn-ui btn-sm task-tooltip" data-label="Back">
                <i class="material-icons back-to-tasks task-icon">arrow_back</i>
            </a>
        </div>
        <p class="single-task-description" task-id="<%= id %>"><%= description %></p>
    </script>

    <script type="text/template" id="pagination-template">
        <a href="#" class="pagination-link" title="<%= title %>" data-page="<%= page %>">
            <%= label %>
        </a>
    </script>

</body>

</html>
