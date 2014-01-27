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
        // if event index does not exist, we create it
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
     * Dispatch an event to the list of its subscribers
     *
     * @param eventName
     * @param [event]
     */
    dispatch: function (eventName, event) {
        // if there is no subscription to the event, we do nothing
        if (!this.events.hasOwnProperty(eventName)) {
            return;
        }
        var subscriptions = this.events[eventName];

        for (var index in subscriptions) {
            if (!subscriptions.hasOwnProperty(index)) {
                return;
            }
            if ($.isNull(event)) {
                // creating a default event object
                event = new Unramalak.Event.Event(eventName);
            }
            // current subscription
            var subscription = subscriptions[index];
            // adding event to callback parameters
            var parameters = [event].concat(subscription.parameters);
            // using apply() to have separated parameters in callback
            subscription.callback.apply(subscription.thisObject, parameters);
        }
    }
};

/**
 * EventSubscription
 *
 * Subscription to an event
 */
$.Class('Unramalak.Event.EventSubscription', {}, {
    /**
     * Event's name
     */
    eventName: '',
    /**
     * Callback parameters
     */
    parameters: [],
    /**
     * Optional "this" object passed to callback
     */
    thisObject: null,
    /**
     * If true, subscription will not be removed after event dispatching
     */
    persistent: false,
    /**
     * Callback to call
     */
    callback: function () {
    }
});