<?php

namespace EduCat\Controllers;

use EduCat\Core\{
    App,
    Contrib\Flash,
    Http\Request
};
use EduCat\Core\Http\Controller;
use EduCat\Models\User;

class AdminController extends Controller
{
    public $app_name = 'admin';

    public function __construct()
    {
        $this->User = App::get('factory')->make('User');
    }

    public function dashboard()
    {
        User::ensure_admin();
        return $this->render('dashboard');
    }

    // User List View
    public function get_users()
    {
        User::ensure_admin();
        $users = $this->User->select_all();

        return $this->render('users/list_users', compact('users'));
    }

    // User Detail View
    public function user_details($id)
    {
        User::ensure_admin();
        $user = $this->User->select_by_id($id);

        return $this->render('users/user_details', compact('user'));
    }

    // User Update Form
    public function update_user_form($id)
    {
        User::ensure_admin();
        $user = $this->User->select_by_id($id);

        return $this->render('forms/update_user_form', compact('user'));
    }

    // User Create Form
    public function create_user_form()
    {
        if (App::get('config')['debug'] !== TRUE) {
            User::ensure_admin();
        }

        return $this->render('forms/create_user_form');
    }

    // User Delete Form
    public function delete_user_form($id)
    {
        User::ensure_admin();
        $user = $this->User->select_by_id($id);

        return $this->render('forms/delete_user_form', compact('user'));
    }

    // User Create Endpoint
    public function create_user()
    {
        if (App::get('config')['debug'] !== TRUE) {
            User::ensure_admin();
        }

        $data = Request::data();
        if (
            isset($data['username']) &&
            isset($data['password']) &&
            isset($data['type']) &&
            in_array(strtoupper($data['type']), User::$allowed_types)
        ) {
            Flash::success('User successfully created');
            $this->User->register($data);
            $new_user = $this->User->select_one_where(['username' => $data['username']]);
            return redirect('/admin/users/' . $new_user->id);
        }

        // TODO: This should probably re-render the form with previously used data
        // Also better error checking so we know what's wrong.
        Flash::error('Could not create user. Please try again.');
        return redirect('/admin/users/create');
    }

    // User Update Endpoint
    public function update_user($id)
    {
        User::ensure_admin();

        $data = Request::data();
        $user_data = (array) $this->User->select_by_id($id);
        $new_data = array_filter($data, function ($prop) {
            return !empty($prop) && $prop != "id";
        });

        // Validate type
        if (isset($new_data['type'])) {
            if (!in_array(strtoupper($new_data['type']), User::$allowed_types)) {
                Flash::error('Invalid user type specified.');
                return redirect("/admin/users/" . $id);
            }
        }

        if (isset($new_data['password'])) {
            $new_data['password'] = password_hash($new_data["password"], PASSWORD_BCRYPT);
        }

        // Merge $new_data with validated $user_data
        $new_user_data = array_replace($user_data, $new_data);
        $this->User->update_by_id($new_user_data, $id);
        Flash::success("User has been successfully updated.");
        return redirect("/admin/users/" . $id);
    }

    // User Delete Endpoint
    public function delete_user($id)
    {
        User::ensure_admin();
        $this->User->delete_by_id($id);
        Flash::success("User has been successfully deleted.");
        return redirect("/admin/users");
    }
}
