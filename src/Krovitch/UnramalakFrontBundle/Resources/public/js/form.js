var AttributesForm = {
    minLimit: 0,
    maxLimit: 20,
    remainingPoints: 0,

    init: function (mixLimit, maxLimit, quantity) {
        AttributesForm.minLimit = parseInt(mixLimit);
        AttributesForm.maxLimit = parseInt(maxLimit);
        AttributesForm.remainingPoints = quantity;
    },

    bind: function (selector) {
        $(selector).find('.btn').on('click', function () {
            var input = $(this).parent('.attribute').find('input[type=number]');
            // check for number
            var value = AttributesForm.checkValue(input.val());

            if ($(this).hasClass('btn-plus')) {

                // top limit value
                if (value < AttributesForm.maxLimit) {
                    input.val(value + 1);
                    AttributesForm.remainingPoints--;
                }
            }
            if ($(this).hasClass('btn-minus')) {

                // low limit value
                if (value > AttributesForm.minLimit) {
                    input.val(value - 1);
                    AttributesForm.remainingPoints++;
                }
            }
            $(this).parents(selector).find('.remaining-points').val(AttributesForm.remainingPoints);

            return false;
        });
    },

    checkValue: function (value) {
        value = parseInt(value);
        value = isNaN(value) ? 0 : value;

        if (value < AttributesForm.minLimit) {
            value = AttributesForm.minLimit;
        }
        if (value > AttributesForm.maxLimit) {
            value = AttributesForm.maxLimit;
        }
        return value;
    }
};