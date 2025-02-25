/* prettier-ignore */
import ConfirmationModalProvider from "@/Components/ConfirmationModal/ConfirmationModalProvider";
import { createInertiaApp } from '@inertiajs/react';
import createServer from '@inertiajs/react/server';
import ReactDOMServer from 'react-dom/server';

createServer((page) =>
    createInertiaApp({
        page,
        render: ReactDOMServer.renderToString,
        resolve: (name) => {
            const pages = import.meta.glob('./Pages/**/*.tsx', {
                eager: true,
            });
            return pages[`./Pages/${name}.tsx`];
        },
        // prettier-ignore
        setup: ({App, props}) => (
            <ConfirmationModalProvider>
                <App {...props} />
            </ConfirmationModalProvider>
        ),
    }),
);
