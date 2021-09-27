import { Matrix }     from './adapter';
import { Calculator } from './calculator';
import {
    AdapterInterface,
    CalculatorInterface,
}                     from './contract';
import { Unit }       from './model';

export default function factory(
    units: Unit                           = Unit.SECOND,
    allowStartAndEndIntersection: boolean = true,
    adapter: AdapterInterface             = new Matrix(),
): CalculatorInterface {
    return new Calculator(adapter, units, allowStartAndEndIntersection);
}
