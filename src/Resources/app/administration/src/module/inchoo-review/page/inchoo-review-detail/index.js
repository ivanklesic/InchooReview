import template from './inchoo-review-detail.html.twig';

const { Component, Mixin } = Shopware;

Shopware.Component.register('inchoo-review-detail', {
    template,
    inject: [
        'repositoryFactory'
    ],
    mixins: [
        Mixin.getByName('notification')
    ],
    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },
    data() {
        return {
            review: null,
            processSuccess: false,
            isLoading: false,
            repository: null
        };
    },

    created() {
        this.repository = this.repositoryFactory.create('inchoo_review');
        this.getReview();
    },

    methods: {
        getReview() {
            this.repository
                .get(this.$route.params.id, Shopware.Context.api)
                .then((entity) => {
                    this.review = entity;
                });
        },
        onClickSave() {
            this.isLoading = true;
            this.repository
                .save(this.review, Shopware.Context.api)
                .then(() => {
                    this.getReview();
                    this.isLoading = false;
                    this.processSuccess = true;
                })
                .catch((exception) => {
                    this.isLoading = false;
                    this.createNotificationError({
                        title: this.$tc('inchoo-review.detail.errorTitle'),
                        message: exception
                });
            });
        },
        saveFinish() {
            this.processSuccess = false;
        },
    }
});