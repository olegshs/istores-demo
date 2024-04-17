import './bootstrap';

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/vue3';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import {i18nVue} from 'laravel-vue-i18n';

const appName = process.env.MIX_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({el, App, props, plugin}) {
        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(i18nVue, {
                fallbackMissingTranslations: true,
                resolve: (lang) => import(`../../lang/php_${lang}.json`),
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
