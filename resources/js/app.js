import { createApp, h } from 'vue'
import {createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        // console.log("INITIAL PAGE PROPS", usePage().props)
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(createPinia().use(piniaPluginPersistedstate))
            .use(autoAnimatePlugin)
            .mount(el)
    },
})

