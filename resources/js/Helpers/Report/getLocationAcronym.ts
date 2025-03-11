export const getLocationAcronym = (location: string) => location.slice(location.indexOf('(')).replace(/[()]/g, '');
