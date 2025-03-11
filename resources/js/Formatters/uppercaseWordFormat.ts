export const uppercaseWordFormat = (text: string, replace: string = '_') =>
    text
        .replace(new RegExp(replace, 'g'), ' ')
        .split(' ')
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join(' ');
