<?php

use Illuminate\Support\Collection;

class QuizController extends BaseController
{
    protected $layout = 'layouts.main';

    public function welcome()
    {
        View::share('nav_title', 'Welcome');
        View::share('body_class', 'quiz-welcome bg-mtn');

        $current_quiz = 
            Quiz::orderBy('created_at', 'desc')
                ->first();

        $passed = $this->get_quiz_passed($current_quiz->id);

        $this->layout->content = 
            View::make('site/quiz/welcome', 
                array( 'current_quiz'   => $current_quiz, 
                       'passed'         => $passed ? 1 : 0
                     ));
    }

    public function past()
    {
        View::share('nav_title', 'Past Quizzes');

        $quizzes = Quiz::orderBy('created_at', 'desc')
                        ->skip(1)
                        ->take(3)
                        ->get();

        $quizzes->each(function($quiz)
        {
            $quiz->passed = $this->get_quiz_passed($quiz->id);
        });

        //$queries=DB::getQueryLog();
        //$last_query=end($queries);
        //dd($last_query);

        $this->layout->content = 
            View::make('site/quiz/past', array( 'quizzes'   => $quizzes ));
    }

    public function about($quiz_id)
    {
        View::share('nav_title', 'About CME');

        $quiz = Quiz::findOrFail($quiz_id);

        $this->layout->content = 
            View::make('site/quiz/about', array( 'quiz'   => $quiz ));
    }

    public function home($quiz_id)
    {
        View::share('nav_title', 'Home');
        View::share('body_class', 'quiz-welcome bg-mtn');

        $this->reset_quiz($quiz_id);

        $quiz = Quiz::find($quiz_id);

        $article = Article::orderBy('article_index', 'asc')
                                ->where('quiz_id', '=', $quiz_id)
                                ->first();

        $this->layout->content = 
            View::make('site/quiz/home', array( 'quiz'    => $quiz,
                                                'article' => $article ));
    }

    public function summary($quiz_id, $article_id)
    {
        View::share('nav_title', 'Quiz Summary');

        $quiz           = Quiz::find($quiz_id);
        $articles       = Article::orderBy('article_index', 'asc')
                                ->where('quiz_id', '=', $quiz_id)
                                ->get();
        $article        = Article::find($article_id);

        $questions      = Question::orderBy('created_at', 'asc')
                            ->where('article_id', '=', $article_id)
                            ->get();

        $a_articles     = clone $articles;
        $next_article   = $this->find_next_article($a_articles, $article_id);

        if ( $next_article !== null )
        {
            $next_question = Question::orderBy('id')
                                ->where('article_id', '=', $next_article->toArray()['id'] )
                                ->first();
        }

        $this->layout->content = 
            View::make('site/quiz/summary', 
                array( 'quiz'           => $quiz, 
                       'article'        => $article,
                       'first_question' => $questions->first(),
                       'next_article'   => $next_article
            ));

        $this->layout->article = $article;
    }

    public function question($quiz_id, $article_id, $question_id)
    {
        $quiz            = Quiz::find($quiz_id);
        $question        = Question::find($question_id);
        $questions       = Question::orderBy('id')->where('article_id', '=', $article_id)->get();
        $article         = Article::find($article_id);
        $articles        = Article::orderBy('article_index')->where('quiz_id', '=', $quiz_id)->get();

        // Necessary because the "functional" collection 
        // methods in PHP are destructive, apparently. Gross.
        $b_questions     = clone $questions;
        $a_articles      = clone $articles;

        $article_number  = $this->find_article_number($a_articles, $article_id);
        $question_number = $this->find_question_number($b_questions, $question_id);
        View::share('question_number', $question_number);

        $answers         = Answer::where('question_id', '=', $question_id)->get();

        $choice          = $this->get_choice_value($question_id);
        $question->choice_value = $choice;

        $chars    = range('a','e');

        $i=1;
        foreach( $answers as $answer )
        {
            $answer->answer_char  = $chars[$i-1];
            $answer->answer_value = $i;
            $answer->response     = ($choice === $answer->answer_value) ? 1 : 0;

            ++$i;
        }

        $this->layout->content = View::make('site/quiz/question', 
                                    array( 'quiz'            => $quiz,
                                           'article'         => $article,
                                           'article_number'  => $article_number, 
                                           'question'        => $question,
                                           'question_number' => $question_number,
                                           'question_char'   => ($question->question_type == 'article') ? 'Q' : 'S',
                                           'answers'         => $answers
                                         ));
        $this->layout->article = $article;
    }

    private function does_response_match_answer($question_id)
    {
    }

    public function respond($quiz_id, $article_id, $question_id)
    {
        $quiz            = Quiz::find($quiz_id);
        $question        = Question::find($question_id);
        $questions       = Question::orderBy('id')->where('article_id', '=', $article_id)->get();
        $article         = Article::find($article_id);
        $articles        = Article::orderBy('article_index', 'asc')->where('quiz_id', '=', $quiz_id)->get();

        // Necessary because the "functional" collection 
        // methods in PHP are destructive, apparently. Gross.
        $a_questions     = clone $questions;
        $b_questions     = clone $questions;

        $a_articles      = clone $articles;
        $b_articles      = clone $articles;

        $article_number  = $this->find_article_number($a_articles, $article_id);
        $next_question   = $this->find_next_question($a_questions, $question_id);
        $question_number = $this->find_question_number($b_questions, $question_id);
        $next_article    = $article;

        $answers         = Answer::where('question_id', '=', $question_id)->get();

        $chars = range('a','e');

        /*
        $response = UserResponse::firstOrCreate(
            array('user_id' => Auth::id(),
                  'question_id' => $question_id
        )); */

        //delete old responses by user to question
        UserResponse::where('user_id', '=', Auth::id())->where('question_id', '=', $question_id)->delete();
        $response = new UserResponse;
        $response->user_id = Auth::id();
        $response->question_id = $question_id;

        
        $choice = Input::get('response');

        if ($choice === null)
            $response->choice_value = 0;
        else
            $response->choice_value = $choice;

        $response->save();

        $i=0;
        foreach( $answers as $answer )
        {
            $answer->answer_char = $chars[$i];
            ++$i;
        }

        if( $next_question == null )
        {
            $next_article = $this->find_next_article($b_articles, $article_id);

            if($next_article !== null)
            {
                $next_question = Question::orderBy('id')->where('article_id', '=', $next_article->toArray()['id'] )->first();
            }
            else
            {
                $next_question = null;
            }
        }

        if ( $next_question == null )
        {
            return Redirect::to( '/quiz/complete/' . $quiz_id );
        }
        else if ( $article->id == $next_article->id )
        {
            return Redirect::to( '/quiz/' . $quiz_id . '/' . $next_article->id . '/' . $next_question->id );
        }
        else 
        {
            return Redirect::to( '/quiz/summary/' . $quiz_id . '/' . $next_article->id );
        }
    }

    private function find_next_question($questions, $question_id)
    {
        $i=1;
        $question_number = 1;
        $it_question = $questions->shift();
        while( $it_question
        &&     $it_question->id != $question_id )
        {
            ++$i; 
            $question_number  = $i;
            $it_question = $questions->shift();
        }
        $next_question = $questions->shift();
        return $next_question;
    }

    private function find_question_number($questions, $question_id)
    {
        $i=1;
        $question_number = 1;
        $it_question = $questions->shift();
        while( $it_question
        &&     $it_question->id != $question_id )
        {
            ++$i; 
            $question_number  = $i;
            $it_question = $questions->shift();
        }
        return $question_number;
    }

    private function find_article_number($articles, $article_id)
    {
        $i=1;
        $article_number = 1;
        $it_article = $articles->shift();
        while( $it_article
        &&     $it_article->id != $article_id )
        {
            ++$i; 
            $article_number  = $i;
            $it_article = $articles->shift();
        }
        return $article_number;
    }

    private function find_next_article($articles, $article_id)
    {
        $j=1;
        $article_number = 1;
        $it_article = $articles->shift();

        while( $it_article
        &&     $it_article->id != $article_id )
        {
            ++$j; 
            $article_number  = $j;
            $it_article = $articles->shift();
        }
        $next_article = $articles->shift();
        return $next_article;
    }

    private function find_question_response($question_id)
    {
        $response = UserResponse::orderBy('id')
            ->whereRaw('user_id =' . Auth::id() . ' and question_id = ' . $question_id)
            ->get();
        return $response;
    }

    private function get_choice_value($question_id)
    {
        $response = $this->find_question_response($question_id);

        if ($response->fetch('choice_value')->count() != 0)
            return intval($response->fetch('choice_value')[0]);
        else
            return 0;
    }

    private function find_answer_value($question_id)
    {
        $answers = Answer::where('question_id', '=', $question_id)->get();

        $answer_value = 1;
        foreach( $answers as $answer )
        {
            if ($answer->is_correct === 1) return $answer_value;
            ++$answer_value;
        }
    }

    private function get_answer_from_choice($question_id, $choice_value)
    {
        $answers = Answer::where('question_id', '=', $question_id)->get();

        $i=1;
        $answer_value = 1;
        $chars    = range('a','e');
        foreach( $answers as $answer )
        {
            $answer['answer_character'] = $chars[$i-1];
            if ($answer_value === $choice_value) return $answer;
            ++$i;
            ++$answer_value;
        }
    }

    private function get_correct_answer($question_id)
    {
        $answers = Answer::where('question_id', '=', $question_id)->get();

        $i=1;
        $answer_value = 1;
        $chars    = range('a','e');
        foreach($answers as $answer)
        {
            $answer['answer_character'] = $chars[$i-1];
            $answer['answer_value']     = $answer_value;
            if ($answer['is_correct'] == 1) return $answer;
            ++$i;
            ++$answer_value;
        }
    }

    public function skip($quiz_id, $article_id, $skip_article_id=null)
    {
        // Set all responses for skipped article to 0 UPDATE IF EXISTS
        $questions = 
            Question::where( 'article_id', '=', $article_id )
            ->get();

        $questions->each(function($question)
        {
            $response = UserResponse::firstOrCreate( 
                array( 
                    'user_id'     => Auth::id(),
                    'question_id' => $question->id
                )
            );

            $response->choice_value = 0;
            $response->save();
        });

        if ( $skip_article_id == null )
        {
            return Redirect::to( '/quiz/complete/' . $quiz_id );
        }
        else
        {
            return Redirect::to( '/quiz/summary/' . $quiz_id . '/' . $skip_article_id );
        }
    }

    public function complete($quiz_id)
    {
        View::share('nav_title', 'Quiz');
        View::share('body_class', 'quiz-welcome bg-mtn');

        $quiz       = Quiz::find($quiz_id);

        $user_id = Auth::id();

        $response_count  = DB::table('responses')
            ->join('questions', 'questions.id', '=', 'responses.question_id')
            ->join('articles',  'articles.id',  '=', 'questions.article_id')
            ->join('quizzes',   'quizzes.id',   '=', 'articles.quiz_id')
            ->where('responses.user_id', '=', $user_id) 
            ->count() ;

        //$queries = DB::getQueryLog();
        //dd(end($queries));

        $quiz_complete = false;

        if ( $response_count >= 20 )
            $quiz_complete = true;

        $this->layout->content = View::make('site/quiz/complete', 
                                                array( 'quiz'          => $quiz,
                                                       'quiz_complete' => $quiz_complete ));
    }

    public function results($quiz_id)
    {
        View::share('nav_title',  'Results');
        View::share('body_class', 'results');

        $user = Auth::user();
        $quiz = Quiz::find($quiz_id);

        $results = $this->get_results($quiz_id);

        $certificate = new Certificate;
        $certificate->user_id = $user->id;
        $certificate->quiz_id = $quiz->id;
        $certificate->credits = $results['credits'];
        $certificate->percent_correct = $results['percent_correct'];

        $certificate->save();

        $cert = new stdClass();

        $cert->name               = $user->first_name . " " . $user->last_name;
        $cert->email              = $user->email;
        $cert->quiz_name          = $quiz->quiz_name;
        $cert->credits            = $certificate->credits;
        $cert->quiz_id            = $quiz->id;
        $cert->user_id            = $user->id;
        $cert->issue_date         = $certificate->created_at->format('m-d-Y');

        if($results['passed']){
            $success = Mail::send('site/quiz/certificate',
                array(
                    'certificate' => $cert,
                    'user'        => $user
                ),
                function($message) use ($cert)
                {
                    $message->to($cert->email, $cert->name)->bcc('permanente.journal@kp.org')->subject('Your certificate from The Permanente Journal');
                }
            );
        }

        $response = array( 
            'status' => 'success',
            'msg'    => "Your Credit Certificate emailed to: $cert->email"
        );

        $quiz = Quiz::find($quiz_id);
        $this->layout->content = View::make('site/quiz/results', 
            array( 'quiz'            => $quiz,
                   'percent_correct' => $results['percent_correct'],
                   'passed'          => $results['passed'],
                   'credits'         => $results['credits'],
                   'response'        => $response,
                   'cert'            => $cert
                 ));
    }

    public function retake($quiz_id)
    {
        $this->reset_quiz($quiz_id);

        return Redirect::to( '/quiz/home/' . $quiz_id );
    }

    private function reset_quiz($quiz_id)
    {
        $user_id = Auth::id();

        $responses = $this->get_quiz_response_ids($user_id, $quiz_id);

        foreach( $responses as $response )
        {
            UserResponse::where('id','=', $response->id)->delete();
        }
    }

    private function get_quiz_passed($quiz_id)
    {
        $exists  = $this->get_quiz_response_exists($quiz_id);

        if ( $exists !== true)
        {
            return false;
        }
        else
        {
            $results = $this->get_results($quiz_id);
            return $results['passed'];
        }
    }

    private function get_quiz_response_exists($quiz_id)
    {
        $user_id = Auth::id();

        $result = DB::select('
            SELECT COUNT(responses.id) as count
            FROM responses 
            INNER JOIN  questions ON responses.question_id = questions.id
            INNER JOIN  articles  ON questions.article_id  = articles.id
            INNER JOIN  quizzes   ON articles.quiz_id = quizzes.id AND quiz_id = ?
            WHERE       articles.deleted_at IS NULL 
            AND         questions.deleted_at IS NULL 
            AND         responses.deleted_at IS NULL 
            AND         responses.user_id = ?
            ;
        ', array( $quiz_id, $user_id ));

        $count = (intval($result[0]->count));

        $ret = false;

        if ( $count > 0 )
        {
            $ret = true;
        }
        else
        {
            $ret = false;
        }

        // DEBUG
        Log::info('USEFUL: ' . gettype($ret) );

        return $ret;
    }

    private function get_results($quiz_id)
    {
        $user_id = Auth::id();

        $questions = $this->get_quiz_question_ids($quiz_id);

        $correct_responses   = 0;
        $incorrect_responses = 0;
        $response_count      = 0;
        //$question_count      = sizeof($questions) * 2 / 5;
        $question_count      = 0;
        $percent_correct     = 0;
        $passed              = false;

        $i = 1;
        $article_index = -1;
        $credits = array( 0, 0, 0, 0 );

        foreach( $questions as $question )
        {
            if ( $i % 5 == 1 )
            {
                ++$article_index;
            }

            // Article questions only
            // Skip scoring survey questions
            if ( $i % 5 == 3
            ||   $i % 5 == 4
            ||   $i % 5 == 0 )
            {
                ++$i;
                continue;
            }
            else
            {
                ++$i;
            }

            $response_query = $this->get_response_query($question);
            $answer_query   = $this->get_answer_query($question);

            if ( empty($response_query) 
            ||   empty($answer_query) )
            {
                continue;
            }

            $response = $this->extract_response($response_query);
            $answer   = $this->extract_answer($answer_query);

            // If question has not been skipped
            if ( $response != 0 )
            {
                ++$question_count;
                $credits[$article_index] = 1;

                if ( $response === $answer )
                {
                    ++$correct_responses;
                }
                else 
                {
                    ++$incorrect_responses;
                }
            }

            ++$response_count;
        }

        $total_credits = 0;
        foreach ($credits as $cr)
        {
            $total_credits += $cr;
        }

        if ($correct_responses === 0)
            $percent_correct = 0;
        else
            $percent_correct = $this->calculate_results($correct_responses, $incorrect_responses, $question_count);

        if ( $percent_correct >= 50
        &&   $response_count  >= $question_count )
        {
            $passed = true;
        }
        else
        {
            $passed = false;
        }

        return array( 'percent_correct' => $percent_correct,
                      'passed'          => $passed,
                      'credits'         => $total_credits
                    );
    }

    private function calculate_results($correct_responses, $incorrect_responses, $question_count)
    {
        $total_responses = $correct_responses + $incorrect_responses;
        if ($total_responses == 0) 
        {
            return 0;
        }
        else
        {
            /*
            return round(( $correct_responses 
                         / $question_count )
                         *  100, 
                       2);
             */
            return round(   ($correct_responses 
                          / ($correct_responses + $incorrect_responses))
                          *  100, 
                        2);
        }
    }

    private function get_quiz_question_ids($quiz_id)
    {
        return DB::select('
            SELECT      questions.id
            FROM        questions 
            INNER JOIN  articles ON questions.article_id = articles.id 
            WHERE       quiz_id = ? 
            AND         articles.deleted_at IS NULL 
            AND         questions.deleted_at IS NULL 
            GROUP BY    articles.id, questions.id 
            ;
        ', array( $quiz_id ));

        //$queries = DB::getQueryLog();
        //dd(end($queries));
    }

    private function get_quiz_response_ids($user_id, $quiz_id)
    {
        return DB::select('
            SELECT      responses.id
            FROM        responses 
            INNER JOIN  questions ON responses.question_id = questions.id
            INNER JOIN  articles  ON questions.article_id  = articles.id
            INNER JOIN  quizzes   ON articles.quiz_id = quizzes.id AND quiz_id = ?
            WHERE       articles.deleted_at IS NULL 
            AND         questions.deleted_at IS NULL 
            AND         responses.user_id = ?
            ;
        ', array( $quiz_id, $user_id ));

        //$queries = DB::getQueryLog();
        //dd(end($queries));
    }

    private function get_quiz_questions($quiz_id)
    {
        return Question::
            select('questions.id','articles.quiz_id','articles.id as article_id','questions.question_text','questions.question_type')
            ->join('articles', 'questions.article_id', '=', 'articles.id')
            ->orderBy('articles.article_index')
            ->orderBy('questions.id')
            ->where('quiz_id', '=', $quiz_id)->get();
    }

    private function get_response_query($question)
    {
        return UserResponse::where('question_id', '=', $question->id)->where('user_id', '=', Auth::id())->get();
    }

    private function get_answer_query($question)
    {
        return DB::select(
            'SELECT  id + 1 - ( SELECT min(id) 
                                FROM   answers 
                                WHERE  question_id = ? )  
             AS      count_index 
             FROM    answers 
             WHERE   question_id = ? 
             AND     is_correct  = 1
             ;',
             array( $question->id, $question->id )
        );
    }

    private function extract_response($response_query)
    {   
        if ( !empty($response_query[0]) )
        {   
            return intval($response_query->first()->choice_value);
        }   
        else 
        {   
            return 0;
        }   
    }   

    private function extract_answer($answer_query)
    {
        return intval($answer_query[0]->count_index);
    }

    public function incorrect($quiz_id)
    {
        View::share('nav_title', 'Wrong Answers');

        //$wrongs    = array();
        $wrongs = new Collection;

        $questions = $this->get_quiz_questions($quiz_id);
        $questions = $this->add_question_numbers_to_questions($questions);

        $articles        = Article::orderBy('article_index')->where('quiz_id', '=', $quiz_id)->get();

        foreach( $questions as $question )
        {
            $correct_answer     = $this->get_correct_answer($question->id);
            $choice_value       = $this->get_choice_value($question->id);

            if ($choice_value != 0)
            {
                $incorrect_answer   = $this->get_answer_from_choice($question->id, $choice_value);

                if ( $correct_answer 
                &&   $correct_answer->answer_value !== $choice_value )
                {
                    $wrong = new stdClass();

                    $a_articles               = clone $articles;
                    $wrong->article_number    = $this->find_article_number($a_articles, $question->article_id);

                    $wrong->article_id        = $question->article_id;
                    $wrong->question_number   = $question->question_number;
                    $wrong->question_text     = $question->question_text;
                    $wrong->answer_character  = $incorrect_answer->answer_character;
                    $wrong->answer_text       = $incorrect_answer->answer_text;

                    $wrongs->push($wrong);
                }
            }
        }

        $this->layout->content = View::make('site/quiz/incorrect',
            array(
                'wrongs' => $wrongs
            ));
    }

    private function add_question_numbers_to_questions($questions)
    {
        $prev_article_id = $questions[0]->article_id;
        $i = 1;
        foreach($questions as $question)
        {
            if ($prev_article_id !== $question->article_id)
            {
                $i = 1;
            }
            $question->question_number = $i;
            $prev_article_id = $question->article_id;
            ++$i;
        }

        return $questions;
    }

    public function send_certificate()
    {
        $quiz_id = Input::get('quiz_id');
        $user = Auth::user();
        $quiz = Quiz::find($quiz_id);

        $results = $this->get_results($quiz_id);

        $certificate = new Certificate;
        $certificate->user_id = $user->id;
        $certificate->quiz_id = $quiz->id;
        $certificate->credits = $results['credits'];
        $certificate->percent_correct = $results['percent_correct'];

        $certificate->save();

        $cert = new stdClass();

        $cert->name               = $user->first_name . " " . $user->last_name;
        $cert->email              = $user->email;
        $cert->quiz_name          = $quiz->quiz_name;
        $cert->credits            = $certificate->credits;
        $cert->quiz_id            = $quiz->id;
        $cert->user_id            = $user->id;
        $cert->issue_date         = $certificate->created_at->format('m-d-Y');

        $success = Mail::send('site/quiz/certificate',
            array(
                'certificate' => $cert,
                'user'        => $user
            ),
            function($message) use ($cert)
            {
                $message->to($cert->email, $cert->name)->bcc('permanente.journal@kp.org')->subject('Your certificate from The Permanente Journal');
            }
        );

        $response = array( 
            'status' => 'success',
            'msg'    => "Your Credit Certificate emailed to: $cert->email"
        );

        return Response::json( $response );
    }
}
