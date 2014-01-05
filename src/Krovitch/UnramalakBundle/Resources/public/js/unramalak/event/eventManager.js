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
     * @param [persistent]
     */
    subscribe: function (eventName, callback, parameters, thisObject, persistent) {
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
        if ($.isNull(persistent)) {
            persistent = false;
        }
        // creating a subscription object to store events parameters
        var subscription = new Unramalak.Event.EventSubscription();
        subscription.eventName = eventName;
        subscription.callback = callback;
        subscription.parameters = parameters;
        subscription.thisObject = thisObject;
        subscription.persistent = persistent;
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
        var persistentSubscriptions = [];

        for (var index in subscriptions) {
            if (!subscriptions.hasOwnProperty(index)) {
                return;
            }
            if ($.isNull(event)) {
                // creating a default event object
                event = new Unramalak.Event.Event(eventName);
            }

            var subscription = subscriptions[index];

            //console.log('dispatch ?', subscription, 'event.data', event.data);
            // adding event to callback parameters
            var parameters = subscription.parameters;
            //parameters.push(event);

            // using apply() to have separated parameters in callback
            subscription.callback.apply(subscription.thisObject, subscription.parameters.concat([event]));

            if (subscription.persistent) {
                // save subscription
                persistentSubscriptions.push(subscription);
            }
            // we keep only persistent subscriptions
            //this.events[eventName] = persistentSubscriptions;
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
     * @param [name]
     * @param [data]
     */
    init: function(name, data) {
        this.name = name;
        this.data = data;
    }
});

// events constants
var UNRAMALAK_MAP_RENDER = 'unramalak.map.render';
var UNRAMALAK_MAP_REQUIRED_RENDER = 'unramalak.map.required_render';
var UNRAMALAK_MAP_MOUSE_DOWN = 'unramalak.map.mousedown';