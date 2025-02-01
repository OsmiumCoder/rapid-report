export function routeWithQueryParams(
    routeName: string,
    queryParams: Record<string, string>,
    routeArguments?: Record<string, object>
) {
    const path = route(routeName, routeArguments);

    let queryString: string = '';

    if (queryParams) {
        queryString = '?' + new URLSearchParams(queryParams).toString();
    }

    return path + queryString;
}
