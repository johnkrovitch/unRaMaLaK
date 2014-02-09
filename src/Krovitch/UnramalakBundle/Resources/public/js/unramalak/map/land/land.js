/**
 * Unramalak.Land
 */
$.Class('Unramalak.Land', {}, {
    type: 'default',
    image: null,

    render: function () {
        var render = {
            type: 'default',
            value: defaultBackgroundColor
        };
        if (this.type == 'sand') {
            render.type = 'image';
            render.value = 'land_sand_1';
        }
        else if (this.type == 'water') {
            render.type = 'image';
            render.value = 'land_water_1';
        }
        else if (this.type == 'plains') {
            render.type = 'image';
            render.value = 'land_plains_1';
        }
        return render;
    },

    reset: function () {
        this.type = 'default';
    },

    save: function () {
        return {
            type: this.type
        }
    }
});