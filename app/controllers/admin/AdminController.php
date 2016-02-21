<?php namespace admin;

use \URL, \User, \DB, \View, \Input, \Redirect, \Session;

class AdminController extends \BaseController
{
    protected $layout = 'layouts.admin';

    public function adminlist()
    {
        $add_button_text  = "Add New Admin";
        $add_button_url   =  URL::to("/admin/create");

        $table_items = 
            User::select(
                DB::raw('CONCAT(first_name, " ", last_name) AS full_name'), 
                'created_at', 
                'id')
            ->where('is_admin', '=', 1)
            ->get();

        $table_headers = array( "Name", "Date Created", "Actions" );
        $table_content = array( "full_name", "created_at", "id" );

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
    
                            return "<a href=\'" + window.location.origin + "/" + tilde + "admin/edit/" + row[2] + "\'>" + data + "</a>" ;
                        },
                        "targets" : 0
                    },
                    {
                        "render" : function ( data, type, row )
                        {
                            return "<div onclick=\"func.show_modal(" + row[2] + ")\" class=\"btn btn-primary btn-sm table-actions\"><i class=\"fa fa-trash-o\"></i></div>" ;
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
            View::make('admin/admin', array( 'table_items'     => $table_items, 
                                             'table_headers'   => $table_headers,
                                             'table_content'   => $table_content,
                                             'datatables_init' => $datatables_init,
                                             'add_button_url'  => $add_button_url,
                                             'add_button_text' => $add_button_text
                                           ));
    }

    public function create()
    {
        $user = new User;
        $user->is_admin = 1;
        $user->confirmed = 1;
        $user->save();

        $this->layout->content = 
            View::make('admin/adminedit', array( 'user' => $user ));
    }

    public function remove($id)
    {
        $admin = User::find($id);
        $admin->delete();

        return Redirect::to('/admin/list');
    }

    public function edit($id)
    {
        $user = User::find($id);

        $this->layout->content = 
            View::make('admin/adminedit', array( 'user' => $user ));
    }

    public function editpost($id=null)
    {
        if ($id != null)
        {
            $user = User::find($id);
        }
        else
        {
            $user = new User;
        }

        $user->first_name            = Input::get('first_name');
        $user->username              = Input::get('username');
        $user->last_name             = Input::get('last_name');
        $user->email                 = Input::get('email');
        $user->degree                = Input::get('degree');
        $user->password              = Input::get('password');
        $user->password_confirmation = Input::get('password_confirmation');
        $user->is_admin              = 1;
        $user->confirmed             = 1;

        $user->save();

        $id = $user->id;

        $error = $user->errors()->all(':message');
        if (!$error) {
            return Redirect::to('/admin/edit/' . $id)->withInput()->with('success', 'Admin successfully saved.');
        } else {
            return Redirect::back()
                ->withInput()
                ->with('error', $error);
        }
    }
}
