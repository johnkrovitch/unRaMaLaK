/**
 * Raster
 *
 * A raster manipulate an image. It encapsulates paper.js raster
 */
$.Class('Unramalak.Raster', {}, {
    id: '',
    // raster container
    container: null,
    name: '',
    // paper.js raster object
    shape: null,


    /**
     * Initializes a raster
     *
     * @param container paper.js container object
     * @param imageId id of image used for raster
     */
    init: function (container, imageId) {
        var image = $('#' + imageId);

        if ($.isNull(image) || $.isNull(container)) {
            throw new Error('Trying to create a raster on an empty image or without container');
        }
        this.id = imageId;
        this.container = container;
        this.shape = null;
    },

    /**
     * Bind mouse canvas event to fire to container (cell...)
     */
    bind: function () {
        if (!this.shape) {
            throw 'Raster should be rendered before binding it to its container';
        }
        var raster = this;

        this.shape.attach('mousedown', function (paperEvent) {
            raster.container.fire('mousedown', paperEvent);
        });
    },

    /**
     * Render raster. If a raster already exist, it will be removed
     */
    render: function () {
        // if a paper raster already exist, we should remove it
        if (this.shape) {
            this.shape.remove();
        }
        // we create raster here cause paper.js render raster on its creation, so we "delayed" render here
        this.shape = new paper.Raster(this.id);
        this.shape.position = this.container.getPosition();
        // binding events to container
        this.bind();
        //this.shape.sendToBack();
    }
});