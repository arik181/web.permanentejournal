<?php namespace admin;

use \URL, \Quiz, \View, \Article, \Input, \Validator, \Redirect, \Question, \Answer, \DB, \UserResponse;

class ArticleController extends \BaseController 
{
    protected $layout = 'layouts.admin';

    public function create($quiz_id)
    {
        $article = new Article;
        $article->quiz_id = $quiz_id;
        $article_count = Article::where('quiz_id', '=', $quiz_id)->count();

        if ( $article_count > 0 )
            $article->article_index = $this->get_max_article_index($quiz_id) + 1;
        else
            $article->article_index = 1;

        $article->save();

        foreach(range(1,2) as $article_questions)
        {
            $question = new Question;
            $question->question_type = 'article';
            $question->article_id    = $article->id;

            $question->save();

            foreach( range('a','e') as $letter )
            {
                $answer = new Answer;
                $answer->question_id = $question->id;

                $answer->save();
            }
        }

        foreach(range(1,3) as $survey_questions)
        {
            $question = new Question;
            $question->question_type = 'survey';
            $question->article_id    = $article->id;

            $question->save();

            foreach( range('a','e') as $letter )
            {
                $answer = new Answer;
                $answer->question_id = $question->id;

                $answer->save();
            }
        }

        $this->edit($article->id);
    }

    public function remove($quiz_id, $article_id)
    {
        $article = Article::find($article_id);
        $article->delete();

        $questions = Question::where('article_id', '=', $article_id)->get();

        $questions->each(function($question)
        {
            $answers   = Answer::where('question_id', '=', $question->id)->get();
            $answers->each(function($answer)
            {
                $answer->delete();
            });

            $responses = UserResponse::where('question_id', '=', $question->id)->get();
            $responses->each(function($response)
            {
                $response->delete();
            });

            $question->delete();
        });

        return Redirect::to( '/admin/quiz/' . $quiz_id );
    }

    public function edit($id)
    {
        $article = Article::find($id);

        $this->layout->content = 
        View::make('admin/articleedit', array( 'article'   => $article,
                                               'questions' => $article->questions ));
    }

    public function editpost($id)
    {
        $article = Article::find($id);

        $article->article_name     = Input::get('article_name');
        $article->author_email     = Input::get('author_email');
        $article->content          = Input::get('content');
        $article->preview_content  = Input::get('preview_content');

        // validate the info, create rules for the inputs
        $rules = array(
            'article_name'    => 'required'
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // If validator fails, redirect them back
        if ($validator->fails()) {
            // Validation failed send them back with errors
            return Redirect::back()->withErrors($validator)->withInput();
        }

        foreach( $article->questions as $question )
        {
            $question->question_text = Input::get('question_' . $question->id);

            foreach( $question->answers as $answer )
            {
                $answer->answer_text = Input::get('answer_' . $answer->id);
                $answer->is_correct  = (Input::get('question_' . $question->id . '_correct') == $answer->id) ? 1 : 0 ;
                $answer->save();
            }

            $question->save();
        }

        if($article->save()) {
            return Redirect::to('admin/article/'.$id)->with('success', 'Article successfully Saved');
        }

    }

    public function moveup($quiz_id, $article_id)
    {
        $current_index = $this->get_current_article_index($article_id);
        $min_index     = $this->get_min_article_index($quiz_id);

        if ($current_index > $min_index)
        {
            $previous_article_id = intval($this->get_previous_article($quiz_id, $article_id)->id);

            $this->move_article_up($article_id);
            $this->move_article_down($previous_article_id);
        }

        return Redirect::to('admin/quiz/' . $quiz_id);
    }

    public function movedown($quiz_id, $article_id)
    {
        $current_index = $this->get_current_article_index($article_id);
        $max_index     = $this->get_max_article_index($quiz_id);

        if ($current_index < $max_index)
        {
            $next_article_id = intval($this->get_next_article($quiz_id, $article_id)->id);

            $this->move_article_down($article_id);
            $this->move_article_up($next_article_id);
        }

        return Redirect::to('admin/quiz/' . $quiz_id);
    }

    private function get_max_article_index($quiz_id)
    {
        $max_record = DB::select(' SELECT MAX(articles.article_index) AS max
                                   FROM   articles
                                   WHERE  articles.quiz_id = ?
                                   AND    deleted_at IS NULL
                                   GROUP BY quiz_id 
                                   ;
                                 ', array($quiz_id));

        $max = intval($max_record[0]->max);
        return $max;
    }

    private function get_min_article_index($quiz_id)
    {
        $min = intval(DB::select(' SELECT MIN(articles.article_index) AS min
                                   FROM   articles
                                   WHERE  articles.quiz_id = ?
                                   AND    deleted_at IS NULL
                                   GROUP BY quiz_id 
                                   ;
                                 ', array($quiz_id)));
        return $min;
    }

    private function get_current_article_index($article_id)
    {
        return intval(Article::find($article_id)->article_index);
    }

    private function get_previous_article($quiz_id, $article_id)
    {
        $current_index = intval($this->get_current_article_index($article_id));
        $previous_index = $current_index - 1 ;

        return Article::where('article_index', '=', $previous_index)
                        ->where('quiz_id', '=', $quiz_id)
                        ->first();
    }

    private function get_next_article($quiz_id, $article_id)
    {
        $current_index = intval($this->get_current_article_index($article_id));
        $next_index = $current_index + 1 ;

        return Article::where('article_index', '=', $next_index)
                        ->where('quiz_id', '=', $quiz_id)
                        ->first();
    }

    private function move_article_up($article_id)
    {
        $article = Article::find($article_id);
        $article->article_index = $article->article_index - 1;

        $article->save();
    }

    private function move_article_down($article_id)
    {
        $article = Article::find($article_id);
        $article->article_index = $article->article_index + 1;

        $article->save();
    }
}
