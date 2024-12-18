<script>
    Vue.component('reply', {
        template: '#cbz-reply-template',

        props: ['attributes'],

        data() {
            return { 
                id: this.attributes.id,
                editing: false,
                body: this.attributes.body,
                modalTarget: '#flaggingModal' + this.attributes.id,
                reasonForReporting: null,
                isAdmin: "{{ auth()->user() ? (int)auth()->user()->hasRole(['admin']) : 0 }}"
            }
        },

        computed: {
            ago() {
                return moment(this.attributes.created_at).fromNow()
            }
        },

        methods: {
            /**
             * Function to update the reply.
             */
            update() {
                axios.patch(
                    '{{env('APP_URL')}}forum/replies/' + this.attributes.id, 
                {
                    'body': this.body
                });

                this.editing = false;
            },

            /**
             * Function to delete the reply.
             */
            destroy() {
                axios.delete('{{env('APP_URL')}}forum/replies/' + this.attributes.id);

                $(this.$el).fadeOut(300);
            },

            /**
             * Function to report the reply.
             */
            report(id) {
                axios.post('{{env('APP_URL')}}forum/replies/' + id + '/flags', {
                    reason: this.reasonForReporting
                });

                alert("You have successfully reported.");

                $(this.modalTarget).modal('toggle');
            },
        }
    });

    Vue.component('favourite', {
        template: `
        	<button :class="classes" @click="toggleFavourite">
                <span v-text="favouritesCount"></span>
                <i class="fas fa-heart"></i>
            </button>
        `,

        props: ['reply'],

        data() {
            return { 
                isFavourited: this.reply.isFavourited,
                favouritesCount: this.reply.favouritesCount,
            }
        },

        computed: {
            classes() {
                return ['btn', this.isFavourited ? 'primary' : 'default'];
            }
        },

        methods: {
            /**
             * Function to toggle favourite.
             */
            toggleFavourite() {
                if (this.isFavourited) {
                    axios.delete('{{env('APP_URL')}}forum/replies/' + this.reply.id + '/favourites');

                    this.isFavourited = false;
                    this.favouritesCount--;
                } else {
                    axios.post('{{env('APP_URL')}}forum/replies/' + this.reply.id + '/favourites');

                    this.isFavourited = true;
                    this.favouritesCount++;
                }
            }
        }
    });
</script>