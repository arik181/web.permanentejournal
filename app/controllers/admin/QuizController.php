<?php namespace admin;

use \URL, \Quiz, \View, \Input, \Redirect, \Validator, \Article, \UserResponse, \Question, \Answer;

class QuizController extends \BaseController
{
    protected $layout = 'layouts.admin';

    // Quiz Manager
    public function quizlist()
    {
        $add_button_text  = "Add New Quiz";
        $add_button_url   =  URL::to("/admin/quiz/create");
            
        $table_items = Quiz::select()->orderBy('created_at')->get();

        $table_headers = array( "Quiz Name", "Date Created", "Actions" );
        $table_content = array( "quiz_name", "created_at", "id" );

        // Used to inject links into datatables
        $datatables_init = '
            {
                "order": [[1, "desc"]],
                "columnDefs" : 
                [
                    {
                        "render" : function ( data, type, row )
                        {
                            // nasty kludge for the dev server
                            var tilde = window.location.pathname.match(/~permanente/);
                            if ( tilde == null ) 
                            { 
                                tilde = \'\' ;
                            }
                            else 
                            { 
                                tilde = tilde + "/" ;
                            }
    
                            return "<a href=\'" + window.location.origin + "/" + tilde + "admin/quiz/" + row[2] + "\' >" + data + "</a>" ;
                        },
                        "targets" : 0,
                    },
                    {
                        "render" : function ( data, type, row )
                        {
                            return "<div class=\"btn btn-primary btn-sm table-actions\" onclick=\"func.show_modal(" + row[2] + ")\"><i class=\"fa fa-trash-o\"></i></div>" ;
                        },
                        "targets" : -1,
                    },
                    {
                        sortable: false,
                        targets: [ -1 ]
                    }
                ]
            }
            ';

        $this->layout->content = 
            View::make('admin/quizlist', 
                 array('table_items'     => $table_items, 
                       'table_headers'   => $table_headers,
                       'table_content'   => $table_content,
                       'datatables_init' => $datatables_init,
                       'add_button_url'  => $add_button_url,
                       'add_button_text' => $add_button_text
                      ));
    }

    public function create()
    {
        $quiz = new Quiz;
        $quiz->save();

        $id = $quiz->id;

        $this->edit($id);
    }

    public function remove($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $quiz->delete();

        $articles = Article::where('quiz_id', '=', $quiz_id)->get();
        $articles->each(function($article)
        {
            $questions = Question::where('article_id', '=', $article->id)->get();

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

            $article->delete();
        });

        return Redirect::to('admin/quiz');
    }

    public function edit($id)
    {
        $quiz = Quiz::find($id);

        $table_items = 
            Article::orderBy('article_index', 'asc')
                ->where('quiz_id', '=', $id)
                ->get();

        $table_headers = array( "Article Name", "Date Created", "Actions", "Order" );
        $table_content = array( "article_name", "created_at", "id", "article_index" );

        // Used to inject links into datatables
        $datatables_init = '
            {
                "columnDefs" : 
                [
                    {
                        "render" : function ( data, type, row ) 
                        {
                            // nasty kludge for the dev server
                            var tilde = window.location.pathname.match(/~permanente/);
                            if ( tilde == null ) 
                            { 
                                tilde = \'\' ;
                            }
                            else 
                            { 
                                tilde = tilde + "/" ;
                            }
    
                            return "<a href=\'" + window.location.origin + "/" + tilde + "admin/article/" + row[2] + "\'>" + data + "</a>" ;
                        },
                        "targets" : 0
                    },
                    {
                        "render" : function ( data, type, row )
                        {
                            return "<div class=\"btn btn-primary btn-sm table-actions\" onclick=\"func.show_modal(" + ' . $id . ' + ", " + row[2] + ")\"><i class=\"fa fa-trash-o\"></i></div>" ;
                        },
                        "targets" : 2,
                    },
                    {
                        "render" : function ( data, type, row )
                        {
                            // nasty kludge for the dev server
                            var tilde = window.location.pathname.match(/~permanente/);

                            if ( tilde == null ) 
                            { 
                                tilde = \'\' ;
                            }
                            else 
                            { 
                                tilde = tilde + "/" ;
                            }
    
                            return "<a href=\'" + window.location.origin + "/" + tilde + "admin/article/moveup/"  + ' . $id . ' + "/" + row[2] + "\' class=\'btn btn-primary btn-sm table-actions\'><i class=\'fa fa-arrow-up\'></i></a> <a href=\'" + window.location.origin + "/" + tilde + "admin/article/movedown/"  + ' . $id . ' + "/" + row[2] + "\' class=\'btn btn-primary btn-sm table-actions\'><i class=\'fa fa-arrow-down\'></i></a>" ;
                        },
                        "targets" : 3,
                    },
                    {
                        sortable: false,
                        targets: [ 0,1,2 ]
                    }
                ],
                "order": [3, "asc"]
            }
            ';

        $this->layout->content = 
        View::make('admin/quizedit', array( 'table_items'     => $table_items, 
                                            'table_headers'   => $table_headers,
                                            'table_content'   => $table_content,
                                            'datatables_init' => $datatables_init,
                                            'quiz'            => $quiz
                                          ));
    }

    public function editpost($id)
    {
        $quiz = Quiz::find($id);

        $quiz->quiz_name = Input::get('quiz_name');

        // validate the info, create rules for the inputs
        $rules = array(
            'quiz_name'    => 'required'
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // If validator fails, redirect them back
        if ($validator->fails()) {
            // Validation failed send them back with errors
            return Redirect::to('admin/quiz/'.$id)->withErrors($validator);
        }

        if($quiz->save()) {
            return Redirect::to('admin/quiz/'.$id)->with('success', 'Quiz successfully Saved');
        }
    }
}
