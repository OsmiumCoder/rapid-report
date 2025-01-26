import dayjs from "dayjs";

export default function dateTimeFormat(date: string): string
{
    return dayjs(date).format("YYYY-MM-DD, h:mm A");
}
