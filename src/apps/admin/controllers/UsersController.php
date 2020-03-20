<?php

namespace EduCat\Controllers\Admin;

use EduCat\Models\User;
use Educat\Models\RecoveryToken;
use EduCat\Core\{
    App,
    Contrib\Flash,
    Http\Request
};
use EduCat\Core\Http\Controller;

use PHPMailer\PHPMailer\{
    Exception,
    PHPMailer,
    SMTP
};


class UsersController extends Controller
{
    public function init()
    {
        $this->User = App::get('factory')->make('User');
        $this->RecoveryToken = App::get('factory')->make('RecoveryToken');
    }


    public function post_login()
    {
        $data = [
            'username' => Request::data()['username'],
            'password' => Request::data()['password'],
        ];

        if ($this->User->login($data)) {
            $user = $this->User->select_one_where(['username' => $data['username']]);
            if ($user->type === "ADMIN") {
                return redirect('/admin');
            }
            return redirect('/');
        }

        Flash::error('Invalid username and/or password!');
        return redirect('/login');
    }

    public function get_login()
    {
        if (User::is_authenticated()) {
            Flash::warning('You are already logged-in!');
            return redirect('/');
        }

        return $this->render('users/login');
    }

    public function get_logout()
    {
        session_start();
        session_destroy();
        Flash::success("You have been successfully logged-out!");
        return redirect('/');
    }

    public function get_index()
    {
        if (User::is_authenticated()) {
            $user_id = $_SESSION['id'];
            $user = $this->User->select_by_id($user_id);


            return $this->render('users/index', compact("user"));
        }
    }

    public function get_edit()
    {
        $user_id = $_SESSION['id'];
        $user = $this->User->select_by_id($user_id);

        return $this->render('users/edit', compact('user'));
    }

    public function get_password_reset()
    {

        return $this->render('users/password_reset');
    }
    public function get_pending()
    {
        return $this->render('users/pending');
    }
    public function post_pending()
    {
        $data = [
            'email' => Request::data()['email']
        ];


        if ($this->User->exists("email", $data['email'])) {
            $mail = new PHPMailer(true);
            $mail_cfg = App::get('config')['smtp'];
            $user = $this->User->select_one_where(["email" => $data["email"]]);
            $u_email = $user->email;
            try {
                $u_id = $user->id;
                // generate a unique random token of length 100
                $token = bin2hex(random_bytes(50));
                $this->RecoveryToken->create([
                    "id" => NULL,
                    "uid" => $u_id,
                    "token" => $token
                ]);
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $mail_cfg['host'];                  // Set the SMTP server to send through
                $mail->SMTPAuth   = $mail_cfg['SMTPAuth'];                                   // Enable SMTP authentication
                $mail->Username   = $mail_cfg['username'];                     // SMTP username
                $mail->Password   = $mail_cfg['password'];                               // SMTP password
                $mail->SMTPSecure = $mail_cfg['SMTPSecure'];         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $mail_cfg['port'];                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('helpdesk.educat@gmail.com', 'Educat Support');
                $mail->addAddress($u_email);     // Add a recipient


                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $user->username . ', reset your password on Educat';
                $mail->Body    = "Hi there, click on this <b><a href=\"http://localhost:8000/password_reset/" . $u_id . "/" . $token . "\">link</a></b> to reset your password on our site";
                $mail->AltBody = "Hi there, click on this <b><a href=\"http://localhost:8000/password_reset/" . $u_id . "/" . $token . "\">link</a></b> to reset your password on our site";

                $mail->send();
                Flash::success('Message has been sent');
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            return $this->render('users/pending', compact('u_email'));
        } else {
            Flash::error('Invalid email');
            return redirect('/password_reset');
        }
    }
    public function get_new_password()
    {
        return $this->render('users/new_password');
    }

    public function post_new_password($id, $token)
    {
        $data = Request::data();
        $user_data = (array) $this->User->select_by_id($id);
        $new_data = array_filter($data, function ($prop) {
            return !empty($prop) && $prop != "id";
        });
        $token = $this->RecoveryToken->select_one_where(['token' => $token]);
        $token_uid = $token->uid;
        if ($token_uid == $id) {
            if (isset($new_data['password'])) {
                $new_data['password'] = password_hash($new_data["password"], PASSWORD_BCRYPT);
            }
            $new_user_data = array_replace($user_data, $new_data);
            // dd($user_data, $new_user_data);
            $this->User->update_by_id($new_user_data, $id);
            Flash::success("Password has been changed, you can now log in.");
            return redirect("/login");
        }
    }




    public function update_user()
    {
        $data = Request::data();
        $user_id = $_SESSION["id"];
        $user_data = (array) $this->User->select_by_id($user_id);
        $new_data = array_filter($data, function ($prop) {
            return !empty($prop) && $prop != "id";
        });
        // Check if image file is a actual image or fake image
        if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] != 4) {
            $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/public/uploads/avatars/";
            $file = $_FILES['profile_picture'];
            $whitelist_type = array('image/jpeg', 'image/png', 'image/jpg');
            $uploadOk = 1;
            if (function_exists('finfo_open')) {
                $fileinfo = finfo_open(FILEINFO_MIME_TYPE);

                if (!in_array(finfo_file($fileinfo, $file['tmp_name']), $whitelist_type)) {
                    Flash::error("Uploaded file is not a valid image, only JPG, JPEG and PNG is valid.");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    Flash::error("Sorry, your file was not uploaded.");
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_dir . $user_id)) {
                        Flash::success("The file " . basename($_FILES["profile_picture"]["name"]) . " has been uploaded.");
                    } else {
                        Flash::error("Sorry, there was an error uploading your file.");
                    }
                }
            }

            if (isset($new_data['password'])) {
                $new_data['password'] = password_hash($new_data["password"], PASSWORD_BCRYPT);
            }

            // Merge $new_data with validated $user_data
            $new_user_data = array_replace($user_data, $new_data);
            $this->User->update_by_id($new_user_data, $user_id);
            Flash::success("User has been successfully updated.");
            return redirect("/profile");
        }
    }
}
