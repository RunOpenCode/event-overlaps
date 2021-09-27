import { Violation }      from '../model';
import { EventInterface } from './event.interface';

export interface CalculatorInterface {

    /**
     * Current number of events within calculator.
     */
    size: number;
    
    /**
     * Add events to calculation.
     */
    append(...events: EventInterface[]): void;

    /**
     * Remove event from calculation.
     */
    remove(event: EventInterface): void;

    /**
     * Remove all events from calculation.
     */
    clear(): void;

    /**
     * Is there overlapping between given events.
     */
    overlaps(): boolean;

    /**
     * Get all overlapping violations.
     */
    violations(): Violation[];
}
