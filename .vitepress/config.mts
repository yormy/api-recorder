import { defineConfig } from 'vitepress'

export default defineConfig({
  title: "Api IO Tracker",
  description: "",
  base: '/api-io-tracker/',
  head: [
    ['link', { rel: "apple-touch-icon", sizes: "180x180", href: "/assets/images/apple-touch-icon.png"}],
    ['link', { rel: "icon", type: "image/png", sizes: "32x32", href: "/assets/images/favicon-32x32.png"}],
    ['link', { rel: "icon", type: "image/png", sizes: "16x16", href: "/assets/images/favicon-16x16.png"}],
  ],
  themeConfig: {
    search: {
      provider: 'local'
    },
    nav: [
      { text: 'Home', link: '/docs/' },
      { text: 'Guide', link: '/docs/v1/introduction/what-is-api-io-tracker' },
    ],

    sidebar: [
      {
        text: 'Introduction',
        items: [
          { text: 'What is Api Io Tracker', link: '/docs/v1/introduction/what-is-api-io-tracker' },
          { text: 'Definitions', link: '/docs/v1/definitions.md' },
          { text: 'Need Support?', link: '/docs/general/support/support-me' },
        ]
      },
      {
        text: 'Getting Started',
        items: [
          { text: 'Installation', link: '/docs/v1/guide/installation' },
          { text: 'Basic Setup', link: '/docs/v1/guide/basic/setup' },
          { text: 'Basic Configuration', link: '/docs/v1/guide/basic/configuration' },
          { text: 'Frontend', link: '/docs/v1//guide/basic/frontend' },
        ]
      },

      { text: 'Contributing', items: [
          { text: 'Report Security Issues', link: '/docs/general/report_security' },
          { text: 'Roadmap', link: '/docs/general/roadmap' },
          { text: 'License', link: '/docs/general/license' },
          { text: 'Change log', link: '/docs/general/changelog' },
          { text: 'Contributing', link: '/docs/general/contributing' },
          { text: 'Code of Conduct', link: '/docs/general/code_of_conduct' },
          { text: 'Credits', link: '/docs/general/credits' },
        ]},

      { text: 'Contact', items: [
          { text: 'Contact', link: '/docs/general/contact' },
          { text: 'Support', link: '/docs/general/support/support-me' },
          { text: 'Donations', link: '/docs/general/support/donations' },
        ]},

    ],

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2022 to present Yormy'
    },
    socialLinks: [
      { icon: 'github', link: 'https://github.com/yormy/api-io-tracker' }
    ]
  }
})
