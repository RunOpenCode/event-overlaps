import {
    AdapterInterface,
    EventInterface,
}                    from '../contract';
import {
    Unit,
    Violation,
}                    from '../model';
import eventOverlaps from './event-overlaps.function';

export class Matrix implements AdapterInterface {

    private events: EventInterface[] = [];

    public get size(): number {
        return this.events.length;
    }

    public append(...events: EventInterface[]): void {
        this.events = [
            ...this.events,
            ...events,
        ];
    }

    public clear(): void {
        this.events = [];
    }

    public remove(event: EventInterface): void {
        this.events = this.events.filter((current: EventInterface): boolean => {
            return current.reference !== event.reference;
        });
    }

    public violations(units: Unit, allowStartAndEndIntersection: boolean = true): Violation[] {
        if (1 >= this.events.length) {
            return [];
        }

        if (2 === this.events.length) {
            if (eventOverlaps(this.events[0], this.events[1], units, allowStartAndEndIntersection)) {
                return [new Violation(this.events[0], this.events[1])];
            }

            return [];
        }

        let violations: Violation[] = [];

        for (let i: number = 1; i < this.events.length; i++) {
            for (let j: number = 0; j < i; j++) {
                if (eventOverlaps(this.events[i], this.events[j], units, allowStartAndEndIntersection)) {
                    violations.push(new Violation(this.events[i], this.events[j]));
                }
            }
        }

        return violations;
    }

}