FormHelper = function() {
    var internal = {

    };

    var external = {
        invalidateField: function(formFieldSelector) {
            $(formFieldSelector).addClass('errored');
        },

        clearError: function(formFieldSelector) {
            $(formFieldSelector).removeClass('errored');
        },

        clearClientSideErrors: function() {
            $('#client-side-errors').hide();
            $('#client-side-errors').html('');
        }
    };

    var initialize = function() {
        $(document).ready(function() {

        });
    }();

    return external;
}();