import { EventInterface } from '../contract';

export class Violation {
    
    private readonly _first: EventInterface;

    private readonly _second: EventInterface;
    
    public constructor(first: EventInterface, second: EventInterface) {
        this._first  = first;
        this._second = second;
    }
    
    public get first(): EventInterface {
        return this._first;
    }

    public get second(): EventInterface {
        return this._second;
    }
}
