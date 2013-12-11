var EventManager = {
    events: [],

    /**
     * Subscribe to an event.
     * Callback will be call with its parameters and thisObject when event will be dispatched
     *
     * @param eventName
     * @param callback
     * @param parameters
     * @param [thisObject]
     */
    subscribe: function (eventName, callback, parameters, thisObject) {

        // null checks
        if ($.isNull(eventName)) {
            throw new Error('Trying to subscribe to an empty event');
        }
        if (typeof callback == 'Function') {
            throw new Error('Passing an invalid callback in event subscription');
        }
        if (!$.isArray(parameters)) {
            throw new Error('Invalid callback parameters in event subscription');
        }
        // if event does not exist, we create it
        if ($.isNull(this.events[eventName])) {
            this.events[eventName] = [];
        }
        // creating a subscription object to store events parameters
        var subscription = new Unramalak.Event.EventSubscription();
        subscription.eventName = eventName;
        subscription.callback = callback;
        subscription.parameters = parameters;
        subscription.thisObject = thisObject;
        // adding callback to queue
        this.events[eventName].push(subscription);
    },

    /**
     *
     *
     * @param eventName
     * @param [data]
     */
    dispatch: function (eventName, data) {
        // if there is no subscription to the event, we do nothing
        if (!this.events.hasOwnProperty(eventName)) {
            return;
        }
        var subscriptions = this.events[eventName];

        for (var index in subscriptions) {
            if (!subscriptions.hasOwnProperty(index)) {
                return;
            }
            // creating the event object
            var event = new Unramalak.Event.Event(data);
            var subscription = subscriptions[index];
            // adding event to callback parameters
            subscription.parameters.push(event);
            console.log('dispatch event', eventName, subscription);
            subscription.callback.apply(subscription.thisObject, subscription.parameters);
        }
    }
};

/**
 * Subscription to an event
 */
$.Class('Unramalak.Event.EventSubscription', {}, {
    /**
     * Event's name
     */
    eventName: '',
    /**
     * Callback to call
     */
    callback: function () {
    },
    /**
     * Callback parameters
     */
    parameters: [],
    /**
     * Optional "this" object passed to callback
     */
    thisObject: null
});

/**
 * Event
 */
$.Class('Unramalak.Event.Event', {}, {
    /**
     * Event name
     */
    name: '',
    /**
     * Event optional data
     */
    data: null,

    /**
     * Event constructor
     *
     * @param [data]
     */
    init: function(data) {
        this.data = data;
    }
});