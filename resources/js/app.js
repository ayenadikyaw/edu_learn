import '../css/app.css';
import './bootstrap';

import 'nprogress/nprogress.css';

import { createInertiaApp, router } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Carousel from 'primevue/carousel';
import 'primeicons/primeicons.css';
import { usePage } from '@inertiajs/vue3';
import ToastService from 'primevue/toastservice';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import ConfirmationService from 'primevue/confirmationservice';


const appName = 'EduLearn';

createInertiaApp({
    title: (title) => `${title} | ${appName}`,
    resolve: async name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        //To fix  
        // if (!page) {
        //     throw new Error(`Page ${name} not found`);
        //     return;
        // }
        
        // const DefaultLayout = (await import('@/Components/Layouts/default.vue')).default;
        // const AuthenticatedLayout = (await import('@/Components/Layouts/authenticated.vue')).default;
        // const AdminLayout = (await import('@/Components/Layouts/adminLayout.vue')).default;
        
        // if (!page.default.layout) {
        //     const currentPath = window.location.pathname;
        
        //     // Get props directly from usePage()
        //     const pageProps = usePage()?.props || {};
        
        //     // Debugging: Log the resolved props
        //     console.log('Resolved pageProps:', pageProps);
        
        //     // Logout detected from flash messages
        //     if (pageProps?.flash?.clearAdminLayout) {
        //         console.log('Logout detected, applying DefaultLayout');
        //         page.default.layout = DefaultLayout;
        //     }
        //     // Check for admin routes or roles
        //     else if (currentPath.toLowerCase().startsWith('/admin')) {
        //         console.log('Admin route detected, applying AdminLayout');
        //         page.default.layout = AdminLayout;
        //     } else if (pageProps?.auth?.user) {
        //         // Apply layout based on the user's role
        //         if (pageProps.auth.user.role === 'admin') {
        //             console.log('Admin user detected, applying AdminLayout');
        //             page.default.layout = AdminLayout;
        //         } else {
        //             console.log('Authenticated user detected, applying AuthenticatedLayout');
        //             page.default.layout = AuthenticatedLayout;
        //         }
        //     } else {
        //         console.log('No auth detected, applying DefaultLayout');
        //         page.default.layout = DefaultLayout;
        //     }
        // }
        
    return page.default;
},
        
    
    
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(ZiggyVue);
        app.use(PrimeVue);
        app.use(ToastService);
        app.component('Toast', Toast);
        app.component('Carousel', Carousel);
        app.component('ConfirmDialog', ConfirmDialog);
        app.use(ConfirmationService);
        app.mount(el);
       
    },
    progress: {
        color: '#7ed957',
        includeCSS: true,
        showSpinner: true,
        delay: 250,
        minimum: 0.1,
        easing: 'ease',
        speed: 500,
    },
});


