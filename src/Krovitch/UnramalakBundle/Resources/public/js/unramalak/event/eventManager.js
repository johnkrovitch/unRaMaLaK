//$.Class('Unramalak.Event.EventManager', {}, {
//  events: [],
//
//  subscribe: function (event, callback) {
//
//    if ($.isNull(this.events[event])) {
//      this.events[event] = [];
//    }
//    this.events[event].push(callback);
//  },
//
//  dispatch: function (eventName) {
//
//    var eventToDispatch = this.events[eventName];
//
//    if ($.isNotNull(event)) {
//
//      for (var event in this.events) {
//        if (this.events.hasOwnProperty(event) && event == eventToDispatch) {
//
//          for (var callback in event) {
//            if (event.hasOwnProperty(callback)) {
//              // TODO add some data to the event
//              var eventObject = new Unramalak.Event();
//              callback.apply(eventObject);
//            }
//            else {
//              throw new Error('Invalid callback was passed to eventManager');
//            }
//          }
//        }
//      }
//    }
//  }
//});
//
//$.Class('Unramalak.Event.Event', {}, {
//  name: '',
//  data: ''
//});