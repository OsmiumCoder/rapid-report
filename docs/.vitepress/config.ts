import { defineConfig } from 'vitepress'

export default defineConfig({
  title: "Rapid Report Documentation",
  description: "Documentation for Rapid Report",
  themeConfig: {
    nav: [
      { text: 'Home', link: '/' },
    ],

    sidebar: [
      {
        text: 'Documentation',
      }
    ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/OsmiumCoder/rapid-report' }
    ]
  }
})
