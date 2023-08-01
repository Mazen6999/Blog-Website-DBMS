<?php

class users {
    public $id;
    public $name;
    public $email;
    protected $password;
    public $image;

    public function __construct($id,$name,$email,$password,$image) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->image = $image;
    }

    static function login($email,$password){
        $user=null;
        $email=htmlspecialchars(trim($email));
        $password=trim(md5($password));

        $qry="SELECT * FROM users WHERE email='$email' AND password='$password'";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        if($rslt = mysqli_fetch_assoc($rsult)){
            switch($rslt['role']){
                case 'user':
                    $id=$rslt['user_id'];
                    $name=$rslt['name'];
                    $email=$rslt['email'];
                    $password=$rslt['passwird'];
                    $image=$rslt['image'];
                    $user=new user($id,$name,$email,$password,$image);
                    break;
    
                case 'admin':
                    $id=$rslt['user_id'];
                    $name=$rslt['name'];
                    $email=$rslt['email'];
                    $password=$rslt['passwird'];
                    $image=$rslt['image'];
                    $user=new admin($id,$name,$email,$password,$image);
                    break;

            }
        }
        return $user;  
    } 
    
    static function signup($name,$email,$password,$image){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = md5( $_POST["password"] );
        $qry = "INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `image`) VALUES (NULL, '$name', '$email', '$password', DEFAULT, '$image')";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        //var_dump($cn);
        try {
            $rsult = mysqli_query($cn,$qry);
        } catch (\Throwable $th) {
            header("location:signup.php?msg=e_a_t");
        }
        mysqli_close($cn);
        header("location:index.php?msg=signup_success");
    }

    Static function showAllPosts(){
        $qry = " SELECT p.post_id,p.title,p.body,p.created_at,p.author_id,p.image,u.name,u.email,u.image FROM posts as p JOIN users as u ON u.user_id=p.author_id ORDER BY p.created_at DESC";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }
    function showAllMyPosts($id){
        $qry = " SELECT p.post_id,p.title,p.body,p.created_at,p.author_id,p.image,u.name,u.email,u.image FROM posts as p JOIN users as u ON u.user_id=p.author_id WHERE p.author_id=$id  ORDER BY p.created_at DESC; ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }
    function showPost($id){
        $qry = " SELECT * FROM posts WHERE post_id='$id' ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }


    function addPost($author_id,$title,$body,$image){
        $qry = " INSERT INTO `posts` (`post_id`, `title`, `body`, `created_at`, `author_id`, `image`) VALUES (NULL, '$title', '$body' , current_timestamp(), '$author_id', '$image') ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function deletePost($id){
        $qry = " DELETE FROM posts WHERE post_id='$id' ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function editPost($id,$body){
        $qry = " UPDATE posts SET body='$body' WHERE post_id='$id' ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }


    static function showComments($parent_post_id){
        $qry = " SELECT u.image,u.name,u.email,c.created_at,c.body,c.comment_id,u.user_id FROM comments as c  JOIN users as u ON u.user_id=c.author_id  WHERE parent_post_id=$parent_post_id ORDER BY c.created_at ASC;";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }
    static function showComment($comment_id){
        $qry = " SELECT body FROM comments  WHERE comment_id=$comment_id ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }
    function addComment($parent_post_id,$author_id,$body){
        $qry = " INSERT INTO `comments` (`comment_id`, `parent_post_id`, `author_id`, `body`, `created_at`) VALUES (NULL, '$parent_post_id', '$author_id', '$body', current_timestamp()) ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function deleteComment($id){
        $qry = " DELETE FROM comments WHERE comment_id='$id' ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    function editComment($id,$body){
        $qry = " UPDATE comments SET body='$body' WHERE comment_id='$id' ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        mysqli_close($cn);
        return $rsult;
    }
    

    function addReact(){}
    function deleteReact(){}


}

class user extends users{
    public $role = 'user';

    

}

class admin extends users{
    public $role = 'admin';
    
    
    function countUsers(){
        $qry = " SELECT COUNT(user_id) FROM `users`; ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_assoc($rsult);
        mysqli_close($cn);
        return $data;
    }
    static function countPosts(){
        $qry = " SELECT COUNT(post_id) FROM `posts`; ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_assoc($rsult);
        mysqli_close($cn);
        return $data;
    }
    static function countComments(){
        $qry = " SELECT COUNT(comment_id) FROM `comments`; ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_assoc($rsult);
        mysqli_close($cn);
        return $data;
    }
    function showUsers(){
        $qry = " SELECT * FROM `users`; ";
        require_once("config.php");
        $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
        $rsult = mysqli_query($cn,$qry);
        $data = mysqli_fetch_all($rsult);
        mysqli_close($cn);
        return $data;
    }
    function deleteUser($id){
            $qry = " DELETE FROM users WHERE user_id='$id' ";
            require_once("config.php");
            $cn= mysqli_connect(DB_HOST,DB_USER_NAME,DB_USER_PW,DB_NAME);
            $rsult = mysqli_query($cn,$qry);
            mysqli_close($cn);
            return $rsult;
    }


}
