/**
 * Raster
 *
 * A raster manipulate an image. It encapsulates paper.js raster
 */
$.Class('Unramalak.Raster', {}, {
    // raster container
    container: null,
    name: '',
    // paper.js raster object
    shape: null,


    init: function (imageId) {
        var image = $('#' + imageId);

        if ($.isNull(image)) {
            throw new Error('Trying to create a raster on an empty image');
        }
       // this.shape = new paper.Raster(image);
    },

//    bindToContainer: function (event, container) {
//        if (!this.shape) {
//            throw 'Raster should be rendered before binding it to its container';
//        }
//        this.shape.attach(event, function (paperEvent) {
//            container.shape.fire(event, paperEvent);
//        });
//    },
//
    render: function () {


//        //this.shape = Unramalak.ImageLoader.createRaster(this.name);
//        this.shape.setPosition(this.container.getPosition());
//        this.bindToContainer('mousedown', this.container);
//        this.bindToContainer('mouseup', this.container);
//        this.bindToContainer('mousedrag', this.container);
    }
//
//    remove: function () {
//        this.shape.remove();
//    }
});