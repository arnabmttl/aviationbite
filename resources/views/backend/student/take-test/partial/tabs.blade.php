<nav>
    <ul class='tabs takeTestSlider owl-carousel owl-theme'>
        <div class="item">
            <li class='active' data-tab-id='tab1'><i class="fas fa-caret-right"></i> Question</li>
        </div>
        <div class="item">
            <li data-tab-id='tab6'><i class="far fa-compass"></i> FLT. comp</li>
        </div>
    </ul>
</nav>
<div class="">
    <div class='content-section'>
        <div id='tab1' class='content active'>
            <p style="color: #000; font-weight: 500;">@{{ selectedQuestion?.question?.title }}</p>
            <div class="forumCardCont">
                <div v-if="selectedQuestion?.question?.image" class="col-12">
                    <img :src="selectedQuestion.question.image">
                </div>
                <div
                    v-for="(option, index) in selectedQuestion?.question?.options"
                    :class="['forumCard', getClassByOption(option), {selected: option?.id == selectedQuestion?.question_option_id}]"
                    v-on:click=selectOption(option)
                    >
                    <div class="ques">
                        <span class="cardNumber">@{{ index+1 }}</span>
                        <p>
                            @{{ option.title }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id='tab3' class='content'>
            <div>
                <div class='content-section'>
                    <div class="forumCardCont">
                        <div class="form-group" >
                            <textarea v-model="commentOnQuestion" placeholder="Have something to comment?" class="form-control" rows="1"></textarea>
                        </div>
                        <button v-on:click="saveCommentByQuestionId()" class="btn btn-primary" style="margin-bottom: 5px;">Comment</button>
                    </div>
                </div>
                <div v-for="(comment, indexOfComment) in selectedQuestion?.comments">
                    <div class="forumCard answerForumCard">
                        <div>
                            <p class="cardText" v-text="comment.comment"></p>
                            <div class="cardFooter">
                                <div class="left">
                                    <i class="far fa-user-circle"></i>
                                    <p> <span v-text="moment(comment.created_at).fromNow()"></span> by <strong>  <a href= "#"> @{{ comment.user.username }}</strong> </a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tab5" class="content">
            <div v-if="selectedQuestion?.question_option_id">
                <span v-html="selectedQuestion?.question?.explanation"></span>
            </div>
        </div>
        <div id="tab6" class="content">
            <div class="content-section">
                <a href="https://online.prepware.com/cx3e/index.html" target="_blank">
                    ASA:: CX-3 (Click to redirect)
                </a>
            </div>
        </div>
    </div>
</div>