<!-- Include SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css">

<!-- Include jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Include SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

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

            cancelEditing() {
                location.reload();
            }, 

            /**
             * Function to delete the reply.
             */
            destroy() {
                // const isConfirmed = window.confirm('Are you sure you want to delete this item?');
                // let id = this.attributes.id;
                // if(isConfirmed){
                //     // axios.delete(`/forum/replies/${id}`);
                //     axios.delete('{{env('APP_URL')}}forum/replies/' + this.attributes.id);

                //     $(this.$el).fadeOut(300);
                // }


                Swal.fire({
                    title: 'Are you sure you want to delete this item?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, keep it',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('{{env('APP_URL')}}forum/replies/' + this.attributes.id);
                        $(this.$el).fadeOut(300);
                        Swal.fire('Deleted!', 'Your reply has been deleted.', 'success');
                    } else {
                        Swal.fire('Okay', 'Your reply is safe :)', 'info');
                    }                        
                });
            },

            /**
             * Function to report the reply.
             */
            report(id) {
                if(this.reasonForReporting == null){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please give some reason',
                        icon: 'warning',
                        confirmButtonText: 'Okay',
                        allowOutsideClick: false,  // Prevent clicking outside to close
                        allowEscapeKey: false
                    });
                }
                axios.post('{{env('APP_URL')}}forum/replies/' + id + '/flags', {
                    reason: this.reasonForReporting
                });

                // alert("You have successfully reported.");
                Swal.fire({
                    title: 'Reported!',
                    text: 'You have successfully reported.',
                    icon: 'info',
                    confirmButtonText: 'Okay',
                    allowOutsideClick: false,  // Prevent clicking outside to close
                    allowEscapeKey: false, 
                    timer: 3000 // The alert will auto-close after 3 seconds
                });

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