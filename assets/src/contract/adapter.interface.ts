import {
    Unit,
    Violation,
}                         from '../model';
import { EventInterface } from './event.interface';

export interface AdapterInterface {

    /**
     * Current number of events within calculator.
     */
    size: number;
    
    /**
     * Add events to collection.
     */
    append(...events: EventInterface[]): void;

    /**
     * Remove event from collection.
     */
    remove(event: EventInterface): void;

    /**
     * Remove all events from collection.
     */
    clear(): void;

    /**
     * Get all overlapping events violations.
     */
    violations(units: Unit, allowStartAndEndIntersection: boolean): Violation[];
    
}