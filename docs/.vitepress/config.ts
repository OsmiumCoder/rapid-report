import { defineConfig } from 'vitepress';

export default defineConfig({
    title: 'Rapid Report',
    description: 'Documentation for Rapid Report',
    themeConfig: {
        nav: [
            { text: 'Home', link: '/' },
            { text: 'Overview', link: '/overview' },
        ],

        sidebar: [
            {
                text: 'Introduction',
                items: [
                    { text: 'Overview', link: '/overview' },
                    { text: 'Setup', link: '/setup' },
                ],
            },
            {
                text: 'Modules',
                items: [

                ],
            },
            {
                text: 'Misc',
                items: [
                    { text: 'Roles', link: '/roles-permissions' },
                    { text: 'Search', link: '/global-search' },
                    { text: 'File Uploads', link: '/file-uploads' },
                ],
            },
        ],

        socialLinks: [{ icon: 'github', link: 'https://github.com/OsmiumCoder/rapid-report' }],
    },
});
