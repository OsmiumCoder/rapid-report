export default function validatePhoneInput(value: string) {
    value = value.replace(/[^0-9-]/g, '');

    if (value.length > 3 && value[3] !== '-') {
        value = value.slice(0, 3) + '-' + value.slice(3);
    }
    if (value.length > 7 && value[7] !== '-') {
        value = value.slice(0, 7) + '-' + value.slice(7);
    }
    return value.slice(0, 12); // Enforce max length
}
