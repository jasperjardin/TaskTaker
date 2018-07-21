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
