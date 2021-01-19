import template from './inchoo-review-list.html.twig';

const Criteria = Shopware.Data.Criteria;

Shopware.Component.register('inchoo-review-list', {
    // Component configuration here
    template,
    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },
    data() {
        return {
            repository: null,
            reviews: null
        };
    },
    created() {
        // add code to fill the variable 'reviews'
        this.repository = this.repositoryFactory.create('inchoo_review');
        this.repository.search((new Criteria()).addAssociation('customer'), Shopware.Context.api)
            .then((result) => {
                this.reviews = result;
                this.reviews.forEach(review => {
                    review.customer.fullName = review.customer.firstName + ' ' + review.customer.lastName;
                });
            });
    },
    inject: [
        'repositoryFactory'
    ],
    computed: {
        columns() {
            return [{
                property: 'title',
                dataIndex: 'title',
                label: this.$tc('inchoo-review.list.columnTitle'),
                routerLink: 'inchoo.review.detail',
                inlineEdit: 'string',
                allowResize: true,
                primary: true
            },
            {
                property: 'reviewText',
                dataIndex: 'reviewText',
                label: this.$tc('inchoo-review.list.columnText'),
                inlineEdit: 'string',
                allowResize: true,
                primary: false
            },
            {
                property: 'rating',
                dataIndex: 'rating',
                label: this.$tc('inchoo-review.list.columnRating'),
                inlineEdit: 'number',
                allowResize: true,
                primary: false
            },
            {
                property: 'customer.fullName',
                dataIndex: 'customer.lastName, customer.firstName',
                label: this.$tc('inchoo-review.list.columnCustomer'),
                allowResize: true,
                primary: false
            },
            {
                property: 'display',
                dataIndex: 'display',
                label: this.$tc('inchoo-review.list.columnDisplay'),
                inlineEdit: 'boolean',
                allowResize: true,
                primary: false
            },
            ];
        },
    },
});