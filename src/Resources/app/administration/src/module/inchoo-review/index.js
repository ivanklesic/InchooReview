import deDE from './snippet/de-DE.json';
import enGB from './snippet/en-GB.json';
import './page/inchoo-review-list';
import './page/inchoo-review-detail';

Shopware.Module.register('inchoo-review', {
    // configuration here
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',
    title: 'inchoo-review.general.mainMenuItemGeneral',
    description: 'inchoo-review.general.descriptionTextModule',
    name: "Inchoo Review plugin",
    type: "plugin",
    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },
    routes: {
        list: {
            component: 'inchoo-review-list',
            path: 'list'
        },
        detail: {
            component: 'inchoo-review-detail',
            path: 'detail/:id',
            meta: {
                parentPath: 'inchoo.review.list'
            }
        },
        delete: {
            component: 'inchoo-review-delete',
            path: 'delete',
            meta: {
                parentPath: 'inchoo.review.list'
            }
        },
    },
    navigation: [{
        label: 'inchoo-review.general.mainMenuItemGeneral',
        color: '#ff3d58',
        path: 'inchoo.review.list',
        icon: 'default-shopping-paper-bag-product',
        position: 100
    }],
});
