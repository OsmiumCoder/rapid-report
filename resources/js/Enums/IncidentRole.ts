import { uppercaseWordFormat } from '@/Formatters/uppercaseWordFormat';

export enum IncidentRole {
    EMPLOYEE = 1,
    STUDENT = 2,
    VISITOR = 3,
    CONTRACTOR = 4,
}

export const getIncidentRoleKey = (value: number) => uppercaseWordFormat(IncidentRole[value]);
