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
                    :class="['forumCard', {selected: option?.id == selectedQuestion?.question_option_id}]"
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
        <div id="tab6" class="content">
            <div class="content-section">
                <a href="https://online.prepware.com/cx3e/index.html" target="_blank">
                    ASA:: CX-3 (Click to redirect)
                </a>
            </div>
        </div>
    </div>
</div>