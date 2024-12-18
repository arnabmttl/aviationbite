<div class="displayBar">
    <div class="quesCount">
        <span style="color: #333;">Q@{{ (questions.indexOf(selectedQuestion)+1) }}/{{ $practiceTest->questions->count() }} <i class="fas fa-thumbtack" v-on:click="markForReview()"></i></span>
    </div>
    <div>
        
    </div>
    <div class="time">
        <span v-if="isSubmitted === '1'">
            <i class="far fa-clock"></i> @{{ selectedQuestion?.time_taken | prettify }}
        </span>
        <span v-else>
            <i class="far fa-clock"></i> @{{ timer | prettify }}
        </span>
    </div>
    <a
        v-if="questions.length != (questions.indexOf(selectedQuestion)+1)"
        class="next"
        title="Next Question"
        v-on:click="selectQuestion(questions[(questions.indexOf(selectedQuestion)+1)])">
            <i class="fas fa-angle-right"></i>
    </a>
</div>