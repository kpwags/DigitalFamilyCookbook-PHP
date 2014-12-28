Utilities = function() {
    var internal = {

    };

    var external = {
        confirmDeletion: function(name) {
            return confirm("Are you sure you want to delete " + name);
        },

        processAjaxError: function(data) {

        }
    };

    var initialize = function() {
        $(document).ready(function() {
            $('.confirm-delete').click(function() {
                var name = $(this).attr('data-val');
                return external.confirmDeletion(name);
            });
        });
    }();

    return external;
}();