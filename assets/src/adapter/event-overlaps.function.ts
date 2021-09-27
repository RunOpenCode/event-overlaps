import { EventInterface } from '../contract';
import { Unit }           from '../model';

export default function eventOverlaps(first: EventInterface, second: EventInterface, units: Unit, allowStartAndEndIntersection: boolean): boolean {
    
    let firstStart: Date = new Date(first.start.valueOf());
    let firstEnd: Date = new Date(first.end.valueOf());
    let secondStart: Date = new Date(second.start.valueOf());
    let secondEnd: Date = new Date(second.end);
    
    if (Unit.SECOND !== units) {
        firstStart.setSeconds(0);
        firstEnd.setSeconds(0);
        secondStart.setSeconds(0);
        secondEnd.setSeconds(0);
        
        if (Unit.MINUTE !== units) {
            firstStart.setMinutes(0);
            firstEnd.setMinutes(0);
            secondStart.setMinutes(0);
            secondEnd.setMinutes(0);
        }
    }

    let firstStartTimestamp: number  = Math.round(firstStart.getTime() / 1000);
    let firstEndTimestamp: number    = Math.round(firstEnd.getTime() / 1000);
    let secondStartTimestamp: number = Math.round(secondStart.getTime() / 1000);
    let secondEndTimestamp: number   = Math.round(secondEnd.getTime() / 1000);

    if (firstStartTimestamp >= firstEndTimestamp) {
        throw new Error(`Provided event "${first.reference.toString()}" is not valid.`);
    }

    if (secondStartTimestamp >= secondEndTimestamp) {
        throw new Error(`Provided event "${second.reference.toString()}" is not valid.`);
    }

    if (allowStartAndEndIntersection && firstEndTimestamp === secondStartTimestamp) {
        return false;
    }

    if (allowStartAndEndIntersection && secondEndTimestamp === firstStartTimestamp) {
        return false;
    }

    if (firstStartTimestamp <= secondStartTimestamp && firstEndTimestamp >= secondStartTimestamp) {
        return true;
    }

    if (firstStartTimestamp <= secondEndTimestamp && firstEndTimestamp >= secondEndTimestamp) {
        return true;
    }

    if (firstStartTimestamp <= secondStartTimestamp && firstEndTimestamp >= secondEndTimestamp) {
        return true;
    }

    if (firstStartTimestamp >= secondStartTimestamp && firstEndTimestamp <= secondEndTimestamp) {
        return true;
    }

    return false;
}
