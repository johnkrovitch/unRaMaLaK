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
        if ($.isNull(callback)) {
            throw new Error('Passing an empty callback in event subscription');
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
     */
    dispatch: function (eventName) {
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
            var event = new Unramalak.Event.Event();
            var subscription = subscriptions[index];
            // adding event to callback parameters
            subscription.parameters.push(event);
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
    name: '',
    data: null,
    thisObject: null,
    callback: null
});