RecipeAdmin = function() {
    var internal = {
        ingredientCount: -1,
        stepCount: -1
    };

    var external = {
        addIngredient: function(startingNumber) {
            internal.ingredientCount = parseInt(startingNumber);

            var html = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" id=\"ingredient" + internal.ingredientCount + "\" name=\"ingredient[]\" placeholder=\"Ingredient\"></div>";
            internal.ingredientCount++;
            $('#additional-ingredients').append(html);
        },

        addStep: function(startingNumber) {
            internal.stepCount = parseInt(startingNumber);

            var html = "<div class=\"form-group\"><input type=\"text\" class=\"form-control\" id=\"step" + internal.stepCount + "\" name=\"step[]\" placeholder=\"Step\"></div>";
            internal.stepCount++;
            $('#additional-steps').append(html);
        },

        validateCreateRecipe: function() {
            internal.clearError('#name');
            internal.clearError("input[name='ingredient[]']");
            internal.clearError("input[name='step[]']");

            internal.clearClientSideErrors();

            var validForm = true;
            var errors = [];

            var name = $('#name').val();
            if (name == '') {
                internal.invalidateField('#name');
                validForm = false;
                errors.push('Name is required');
            }

            var hasIngredients = false;
            $.each($("input[name='ingredient[]']"), function() {
                if ($(this).val() != "") {
                    hasIngredients = true;
                }
            });

            if (!hasIngredients) {
                internal.invalidateField("input[name='ingredient[]']");
                validForm = false;
                errors.push('There must be at least one (1) ingredient');
            }

            var hasSteps = false;
            $.each($("input[name='step[]']"), function() {
                if ($(this).val() != "") {
                    hasSteps = true;
                }
            });

            if (!hasSteps) {
                internal.invalidateField("input[name='step[]']");
                validForm = false;
                errors.push('There must be at least one (1) step');
            }

            if (errors.length > 0) {
                for (var i = 0; i < errors.length; i++) {
                    $('#client-side-errors').append("<li><span>" + errors[i] + "</span></li>");
                }
                $('#client-side-errors').show();
            }

            return validForm;
        }
    };

    var initialize = function() {
        $(document).ready(function() {
            $('#add-ingredient').click(function() {
                if (internal.ingredientCount == -1) {
                    external.addIngredient( $(this).attr('data-val') );
                } else {
                    external.addIngredient( internal.ingredientCount );
                }
            });

            $('#add-step').click(function() {
                if (internal.stepCount == -1) {
                    external.addStep( $(this).attr('data-val') );
                } else {
                    external.addStep( internal.stepCount );
                }
            });
        });
    }();

    return external;
}();