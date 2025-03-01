import dayjs from 'dayjs';

export default function dateFormat(date: string | number | Date): string {
    return dayjs(date).format('YYYY-MM-DD');
}
