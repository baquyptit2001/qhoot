// https://nuxt.com/docs/api/configuration/nuxt-config
import Components from 'unplugin-vue-components/vite';
import {AntDesignVueResolver} from 'unplugin-vue-components/resolvers';

export default defineNuxtConfig({
    runtimeConfig: {
        public: ['API_URL'],
        private: ['API_KEY'],
    },
    vite: {
        plugins: [
            Components({
                resolvers: [AntDesignVueResolver()],
            }),
        ],
        ssr: {
            noExternal: ['moment', 'compute-scroll-into-view', 'ant-design-vue'],
        },
    },
})
