/**
 * class Unramalak.Container
 */
$.Class('Unramalak.Container', {}, {
  units: [],
  position: null,

  addUnit: function(unit) {
    this.units.push(unit);
  },

  /**
   * Return true if this container has unit
   * @returns {boolean}
   */
  hasUnit: function() {
    return !!(this.units.length > 0);
  },

  // TODO refactor this in behaviour
  getPosition: function () {
    return this.shape.position;
  }
});