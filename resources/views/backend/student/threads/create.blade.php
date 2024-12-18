@extends('layouts.frontend.app')

@section('title', 'Ask A Question')

@section('content')
    <!-- BEGIN: Ask A Question -->
    <section class="forumCont faqsTabsCont pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <p class="title">Ask A Question</p>
                    <div class="">
                        <div class='content-section'>
                            <div id='tab1' class='content active'>
                                <div class="forumCardCont">
                                    <form method="POST" action="{{ route('threads.store') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="channel_id"> Select the topic : </label>
                                            <select name="channel_id" id="channel_id" class="form-control" required>
                                                <option value=""> Choose one...</option>
                                                @foreach($channels as $channel)
                                                    <option value="{{ $channel->id }}" {{ old('channel_id')== $channel->id ? 'selected' : '' }} >
                                                        {{ $channel->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @error('channel_id')
                                                <ul class="alert alert-danger">
                                                    <li> {{ $message }} </li>
                                                </ul>
                                        @enderror
                                        <div class="form-group" >
                                            <label form="title"> Question : </label>
                                            <input data-max-words="20" type="text" name="title" class="form-control" id="title" placeholder="Question" required data-announce="true">
                                        </div>

                                        @error('title')
                                                <ul class="alert alert-danger">
                                                    <li> {{ $message }} </li>
                                                </ul>
                                        @enderror

                                        <div class="form-group" >
                                            <label form="body"> Describe your question in detail if needed : </label>
                                            <textarea placeholder="Describe your question in detail if needed" name="body" id="body" class="form-control" required data-announce="true" onchange="checkWords()""></textarea>
                                        </div>
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Publish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: Ask A Question -->
@endsection

@section('page-scripts')
    <script type="text/javascript">
        // Get all inputs that have a word limit
        document.querySelectorAll('input[data-max-words]').forEach(input => {
          // Remember the word limit for the current input
          let maxWords = parseInt(input.getAttribute('data-max-words') || 0)
          // Add an eventlistener to test for key inputs
          input.addEventListener('keydown', e => {
            let target = e.currentTarget
            // Split the text in the input and get the current number of words
            let words = target.value.split(/\s+/).length
            // If the word count is > than the max amount and a space is pressed
            // Don't allow for the space to be inserted
            if (!target.getAttribute('data-announce'))
              // Note: this is a shorthand if statement
              // If the first two tests fail allow the key to be inserted
              // Otherwise we prevent the default from happening
              words >= maxWords && e.keyCode == 32 && e.preventDefault()
            else
              words >= maxWords && e.keyCode == 32 && (e.preventDefault() || alert('Word Limit Reached'))
          })
        })

        function checkWords() {
            const textarea = document.querySelector('#body');

              // Remember the word limit for the current input
              let maxWords = 60
              // Add an eventlistener to test for key inputs
              textarea.addEventListener('keydown', e => {
                let target = e.currentTarget
                // Split the text in the input and get the current number of words
                let words = target.value.split(/\s+/).length
                // If the word count is > than the max amount and a space is pressed
                // Don't allow for the space to be inserted
                if (!target.getAttribute('data-announce'))
                  // Note: this is a shorthand if statement
                  // If the first two tests fail allow the key to be inserted
                  // Otherwise we prevent the default from happening
                  words >= maxWords && e.keyCode == 32 && e.preventDefault()
                else
                  words >= maxWords && e.keyCode == 32 && (e.preventDefault() || alert('Word Limit Reached'))
              })
        }
    </script>
@endsection