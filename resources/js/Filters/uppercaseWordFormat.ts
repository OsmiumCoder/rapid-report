export const uppercaseWordFormat = (text: string, replace: string = '_') =>
    text
        .replace(replace, ' ')
        .split(' ')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
