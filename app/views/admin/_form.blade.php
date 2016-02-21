<script src="/assets/js/ckeditor/ckeditor.js"></script>
{{ Form::open(array('url' => 'admin/article/' . $article->id, 'class'=>'quiz-form')) }}
    <div class="row">
        <div class="col-xs-7">
            <div class="form-group">
                {{ Form::label('article_name', 'Article Name' ) }}
                {{ Form::text('article_name', $article->article_name, array('class' => 'form-control input-sm', 'placeholder' => 'Article Name' )) }}
            </div>
        </div>
        <div class="col-xs-7">
            <div class="form-group">
                {{ Form::label('author_email', "Author's Email" ) }}
                {{ Form::text('author_email', $article->author_email, array('class' => 'form-control input-sm', 'placeholder' => 'Email' )) }}
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                {{ Form::label('preview_content', 'Preview Content' ) }}
                {{ Form::textarea('preview_content', $article->preview_content, ['size' => '30x5', 'class'=>'form-control']) }}
                <script>
                    CKEDITOR.replace( 'preview_content' );
                </script>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                {{ Form::label('content', 'Content' ) }}
                {{ Form::textarea('content', $article->content, ['size' => '30x5', 'class'=>'form-control']) }}
                <script>
                    CKEDITOR.replace( 'content' );
                </script>
            </div>
        </div>
    </div>

<?php $question_counter = 1; ?>
<?php $survey_question  = 0; ?>
@foreach( $questions as $question )
<?php // Reset counter on page for survey questions ?>
<?php if (( $question_counter === 3) && ( $survey_question === 0)) { $question_counter = 1; $survey_question = 1; }?>
<?php if ( $survey_question === 0 ): ?>
    <div class="form-split show-grid-sm"></div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group">
                <h2>{{ Str::title($question->question_type) }} Question {{ $question_counter }} </h2>
            </div>
            <div class="form-group">
                {{ Form::label('question_' . $question->id, 'Content', array('class'=>'sr-only')  ) }}
                {{ Form::textarea('question_' . $question->id, $question->question_text, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'Question text here...'] ) }}
            </div>
        </div>
    </div>
    <div class="row show-grid-md">
    <?php $letter = array( 'a', 'b', 'c', 'd', 'e' ); ?>
    <?php $letter_counter = 0; ?>
    @foreach( $question->answers as $answer )
        <div class="col-xs-6">
            <div class="row">
                <h3 class="col-xs-6"><?php echo $letter[$letter_counter % 5]; ?></h3>
                <div class="col-xs-6 text-right">
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                {{ Form::radio( 'question_' . $question->id . '_correct', $answer->id, $answer->is_correct )}}  Correct
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                {{ Form::label('answer_' . $answer->id, 'Content', array('class'=>'sr-only')  ) }}
                {{ Form::textarea('answer_' . $answer->id, $answer->answer_text, ['size'=>'30x3', 'class'=>'form-control', 'placeholder'=>'Answer text here...'] ) }}
            </div>
        </div>
        <?php ++$letter_counter; ?>
    @endforeach
    </div>
<?php endif ?>

    <?php ++$question_counter; ?>
@endforeach

<div class="row">
    <div class="col-xs-6 text-right">
        {{ Form::submit('Save', array('class'=>'btn btn-primary btn-md')) }}
    </div>
    <div class="col-xs-6">
        {{ HTML::link( URL::to('/admin/quiz/' . $article->quiz_id ), 'Cancel', array('class'=>'btn btn-tint btn-primary btn-primary-tint btn-md ') ) }}
    </div>
</div>
{{ Form::close() }}
