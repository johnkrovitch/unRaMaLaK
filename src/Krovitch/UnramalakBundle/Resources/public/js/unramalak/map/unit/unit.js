//$.Class('Unramalak.Unit.BaseUnit', {}, {
//
//
//});
//Unramalak.Unit.BaseUnit('Unramalak.Unit', {}, {

/**
 * Unit class
 */
$.Class('Unramalak.Unit', {}, {
    origin: null,
    shape: null,

    init: function () {
        this.origin = new paper.Point(100, 50);
        this.build();
    },

    build: function () {
        // TODO generalize shape build
        var rightLeg = new paper.Path();
        rightLeg.add(this.origin);
        rightLeg.add(new paper.Point(this.origin.x + 20, this.origin.y + 30));

        var leftLeg = new paper.Path();
        leftLeg.add(this.origin);
        leftLeg.add(new paper.Point(this.origin.x - 20, this.origin.y + 30));

        var trunk = new paper.Path();
        trunk.add(this.origin);
        trunk.add(new paper.Point(this.origin.x, this.origin.y - 35));

        var headOrigin = new paper.Point(this.origin.x, this.origin.y - 44);
        var head = new paper.Path.Circle(headOrigin, 10);

        var rightArm = new paper.Path();
        rightArm.add(new paper.Point(headOrigin.x, headOrigin.y + 10));
        rightArm.add(new paper.Point(headOrigin.x - 20, headOrigin.y + 30));

        var leftArm = new paper.Path();
        leftArm.add(new paper.Point(headOrigin.x, headOrigin.y + 10));
        leftArm.add(new paper.Point(headOrigin.x + 20, headOrigin.y + 30));

        this.shape = new paper.Group(rightLeg, leftLeg, trunk, rightArm, leftArm, head);


    },

    /**
     * Return true if current unit can move into this type of land
     */
    canTraverse: function (land) {
        var canTraverse = false;
        // unit can move into sand
        if (land.type == LAND_SAND) {
            canTraverse = true;
        }
        return canTraverse;
    },

    render: function () {
        this.shape.strokeColor = 'black';
    }
});