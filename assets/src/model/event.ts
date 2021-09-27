import { EventInterface } from '../contract';

export class Event implements EventInterface {

    private readonly _reference: any;

    private readonly _start: Date;

    private readonly _end: Date;

    public constructor(reference: any, start: Date, end: Date) {
        this._reference = reference;
        this._start     = start;
        this._end       = end;
    }

    public get reference(): any {
        return this._reference;
    }

    public get start(): Date {
        return this._start;
    }

    public get end(): Date {
        return this._end;
    }

}