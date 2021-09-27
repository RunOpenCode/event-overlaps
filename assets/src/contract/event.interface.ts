export interface EventInterface {
    /**
     * Reference to event.
     */
    reference: any;

    /**
     * Get start date/time of the event.
     */
    start: Date;

    /**
     * Get end date/time of the event.
     */
    end: Date;
}