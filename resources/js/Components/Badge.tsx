import classNames from '@/Filters/classNames';

export type BadgeColor =
    | 'gray'
    | 'red'
    | 'green'
    | 'blue'
    | 'yellow'
    | 'indigo'
    | 'purple'
    | 'pink';

type BadgeProperty = {
    [k in BadgeColor]: {
        backgroundColor: string;
        textColor: string;
        ringColor: string;
    };
};

const badgeColors: BadgeProperty = {
    gray: {
        backgroundColor: 'bg-gray-50',
        textColor: 'text-gray-600',
        ringColor: 'ring-gray-500/10',
    },
    red: {
        backgroundColor: 'bg-red-50',
        textColor: 'text-red-700',
        ringColor: 'ring-red-600/10',
    },
    yellow: {
        backgroundColor: 'bg-yellow-50',
        textColor: 'text-yellow-800',
        ringColor: 'ring-yellow-600/20',
    },
    green: {
        backgroundColor: 'bg-green-50',
        textColor: 'text-green-700',
        ringColor: 'ring-green-600/20',
    },
    blue: {
        backgroundColor: 'bg-blue-50',
        textColor: 'text-blue-700',
        ringColor: 'ring-blue-700/10',
    },
    indigo: {
        backgroundColor: 'bg-indigo-50',
        textColor: 'text-indigo-700',
        ringColor: 'ring-indigo-700/10',
    },
    purple: {
        backgroundColor: 'bg-purple-50',
        textColor: 'text-purple-700',
        ringColor: 'ring-purple-700/10',
    },
    pink: {
        backgroundColor: 'bg-pink-50',
        textColor: 'text-pink-700',
        ringColor: 'ring-pink-700/10',
    },
};

interface BadgeProps {
    color: BadgeColor;
    text: string;
    className?: string;
}

export default function Badge({ color, text, className }: BadgeProps) {
    return (
        <span
            className={classNames(
                'inline-flex items-center rounded-md px-2 py-1 font-medium ring-1 ring-inset',
                badgeColors[color].backgroundColor,
                badgeColors[color].textColor,
                badgeColors[color].ringColor,
                className ?? ''
            )}
        >
            {text}
        </span>
    );
}
