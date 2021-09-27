import {
    AdapterInterface,
    CalculatorInterface,
    EventInterface,
} from './contract';
import {
    Unit,
    Violation,
} from './model';

export class Calculator implements CalculatorInterface {

    private readonly _adapter: AdapterInterface;

    private readonly _units: Unit;

    private readonly _allowStartAndEndIntersection: boolean;

    private _lastViolations: Violation[] | null = null;

    public constructor(adapter: AdapterInterface, units: Unit = Unit.SECOND, allowStartAndEndIntersection: boolean = true) {
        this._adapter                      = adapter;
        this._units                        = units;
        this._allowStartAndEndIntersection = allowStartAndEndIntersection;
    }

    public get size(): number {
        return this._adapter.size;
    }

    public append(...events: EventInterface[]): void {
        this._adapter.append(...events);
        this._lastViolations = null;
    }

    public clear(): void {
        this._adapter.clear();
        this._lastViolations = null;
    }

    public overlaps(): boolean {
        if (null === this._lastViolations) {
            this._lastViolations = this._adapter.violations(this._units, this._allowStartAndEndIntersection);
        }

        return 0 !== this._lastViolations.length;
    }

    public remove(event: EventInterface): void {
        this._adapter.remove(event);
        this._lastViolations = null;
    }

    public violations(): Violation[] {
        if (null === this._lastViolations) {
            this._lastViolations = this._adapter.violations(this._units, this._allowStartAndEndIntersection);
        }

        return this._lastViolations;
    }

}
