import { uppercaseWordFormat } from '@/Formatters/uppercaseWordFormat';

export enum IncidentType {
    SAFETY = 1,
    ENVIRONMENTAL = 2,
    SECURITY = 3,
}

export const getIncidentTypeKey = (value: number) => uppercaseWordFormat(IncidentType[value]);
