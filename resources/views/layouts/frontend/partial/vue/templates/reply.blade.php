<!-- Reply Component Template -->
<script type="text/html" id="cbz-reply-template">
    <div :id="'reply-'+id" class="forumCard answerForumCard">
        <div id="cbz-thread-reply">
            <div v-if="editing">
                <p class="cardText">
                    <div class="form-group">
                        <textarea class="form-control col-12" v-model="body"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button class="btn btn-xs btn-primary" @click="update">Update</button>
                        <button class="btn btn-xs btn-link" @click="cancelEditing()">Cancel</button>
                    </div>
                </p>
            </div>
            <p v-else class="cardText" v-text="body"></p>
            <div class="cardFooter">
                <div class="left">
                    <i class="far fa-user-circle"></i>
                    <p> <span v-text="ago"></span> by <strong>  @{{ attributes.owner.username }}</strong> </p>
                    @auth
                    <div class="right">
                        <img data-bs-toggle="modal" :data-bs-target="modalTarget" src="{{ asset('frontend/images/flag.svg') }}">
                        <favourite :reply=attributes></favourite>
                        <!-- <p>25<img src="{{ asset('frontend/images/message.svg') }}"></p> -->
                    </div>
                    @endauth
                </div>
            </div>
            @auth
            <div class="cardFooter" v-if="(attributes.owner.id == {{ auth()->id() }}) || (isAdmin == 1)">
                <div class="left">
                    <button class="btn btn-xs" @click="editing = true">
                        Edit
                    </button>
                    <button class="btn btn-xs btn-danger" @click="destroy">
                        Delete
                    </button>
                </div>
            </div>
            @endauth
        </div>
        @include('layouts.frontend.partial.modals.flagging')
    </div>
</script>