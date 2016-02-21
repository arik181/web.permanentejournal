<?php

class DatabaseSeeder extends Seeder 
{
    public function run()
    {
        Eloquent::unguard();

        //$this->call('UsersTableSeeder');
        $this->call('QuizzesTableSeeder');
        $this->call('ArticlesTableSeeder');
        $this->call('QuestionsTableSeeder');
        $this->call('AnswersTableSeeder');
    }
}

class UsersTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('users')->delete();

        User::create(
            array('email'      => 'arik181@gmail.com',
                  'username'   => 'arik181',
                  'first_name' => 'arik',
                  'last_name'  => 'oneeightone'
        ));
    }
}

class QuizzesTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('quizzes')->delete();

        $i = 1;
        for ($i=1; $i < 101; ++$i)
        {
            Quiz::create(
                array('quiz_name'  => 'Quiz ' . strval($i))
            );
        }
    }
}

class ArticlesTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('articles')->delete();

        $article = 1;
        $quiz_id = 1;
        for ($article=1; $article < 101; ++$article)
        {
            if ( $article % 5 == 0 ) ++$quiz_id;

            Article::create(
                array( 'article_name'  => 'Article ' . strval($article),
                       'quiz_id'       => $quiz_id )
            );
        }
    }
}

class QuestionsTableSeeder extends Seeder 
{
    public function run()
    {
        DB::table('questions')->delete();

        $article = 1;
        for ($article=1; $article < 25; ++$article)
        {
            $question = 1;
            for ($question=1; $question < 6; ++$question)
            {
                // Create an article question
                if ( $question < 4 )
                {
                   $create = array( 'question_type'    => 'article',
                                    'article_id'       => $article,
                                    'question_choice'  => $question );
                } else {

                   $create = array( 'question_type'    => 'survey',
                                    'article_id'       => $article,
                                    'question_text'    => 'Question ' . strval($article * $question) );
                }

                Question::create( $create );
            }
        }
    }
}

class AnswersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('answers')->delete();

        $article = 1;
        for ($article=1; $article < 25; ++$article)
        {
            $question = 1;
            for ($question=1; $question < 6; ++$question)
            {
                // Create answers for each question
               $create = array( 'question_id'      => $article,
                                'answer_text'      => 'answer text' );

                Answer::create( $create );
            }
        }
    }
}

