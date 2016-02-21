<?php

class ArticleController extends BaseController 
{
    protected $layout = 'layouts.main';

    public function articleList($quiz_id)
    {
        View::share('nav_title', 'Article List');

        $articles = Article::orderBy('article_index', 'asc')
                        ->where('quiz_id', '=', $quiz_id)
                        ->get();

        $this->layout->content = 
            View::make('site/article/list', array( 'articles'   => $articles ));
    }

    public function full($id)
    {
        View::share('nav_title', 'Full Article');
        View::share('wrong', false);
        View::share('quiz',  false);

        $article = Article::find($id);

        $this->layout->content = 
            View::make('site/article/full', array( 'article'   => $article ));

        $this->layout->article = $article;
    }

    public function fullWrong($id)
    {
        View::share('nav_title', 'Full Article');
        View::share('wrong', true);
        View::share('quiz',  false);

        $article = Article::find($id);

        $this->layout->content = 
            View::make('site/article/full', array( 'article'   => $article ));

        $this->layout->article = $article;
    }

    public function fullQuiz($id)
    {
        View::share('nav_title', 'Full Article');
        View::share('wrong', false);
        View::share('quiz',  true);

        $article = Article::find($id);

        $this->layout->content = 
            View::make('site/article/full', array( 'article'   => $article ));

        $this->layout->article = $article;
    }
}
