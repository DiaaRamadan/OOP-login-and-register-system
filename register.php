<?php

require_once "core/init.php";
if (Input::exist()){
    if(Token::check(Input::get('token'))) {

        $validator = new Validate();
        $validation = $validator->check($_POST, array(

            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
            ),
            'password_again' => array(

                'required' => true,
                'min' => 6,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
            )
        ));
        if ($validation->passed()) {
            $user = new User();
            try{

                $salt = Hash::salt(32);
                $user->create([

                    'username' => Input::get('username'),
                    'password' =>  Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => date('Y-m-d H:i:s'),
                    'name' => Input::get('name'),
                    'group' => 1
                ]);

                Session::flash('home', 'You are register successfully');
                Redirect::to('index.php');

            }catch (Exception $e){
                die($e->getMessage());
            }

        } else {
            foreach ($validation->errors() as $error) {

                echo $error . "<br>";
            }
        }

    }
}

?>

<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username'))?>" autocomplete="off">
    </div>

    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="field">
        <label for="password_again">Enter password again</label>
        <input type="password" name="password_again" id="password_again">
    </div>

    <div class="field">
        <label for="name">Enter your name </label>
        <input type="text" name="name" value="<?php echo escape(Input::get('name'))?>" id="name">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate()?>">

    <input type="submit" value="Register">
</form>