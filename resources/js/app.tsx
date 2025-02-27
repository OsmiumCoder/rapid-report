import '../css/app.css';

import ConfirmationModalProvider from '@/Components/ConfirmationModal/ConfirmationModalProvider';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot, hydrateRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.tsx`, import.meta.glob('./Pages/**/*.tsx')),
    setup({ el, App, props }) {
        if (import.meta.env.SSR) {
            hydrateRoot(
                el,
                <ConfirmationModalProvider>
                    <App {...props} />
                </ConfirmationModalProvider>,
            );
            return;
        }

        createRoot(el).render(
            <ConfirmationModalProvider>
                <App {...props} />
            </ConfirmationModalProvider>,
        );
    },
    progress: {
        color: '#4B5563',
    },
});
