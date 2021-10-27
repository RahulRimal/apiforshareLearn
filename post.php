<?php require('core/init.php');?>


<?php

    $template = new Template('templates/post-page.php');

    $post = new Post();
    $user = new User();

    $postId = isset($_GET['post']) ? $_GET['post'] : null;


    if($postId != null)
    {
        $uid = $post->userIdFromPost($postId);

        
        $template->userInfo = $user->getUserInfo($uid);
        
        $template->followers = $user->userFollowersCount($uid);
        $template->userRating = $user->userOverallRating($uid);

        $template->post = $post->getPost($postId);

        $template->postComments = $post->getReplies($postId);

    }
    else
    {
        redirect('index.php');
    }



    if(isset($_POST['doReply']))
    {

        $data = array();
        $data['postId'] = $_GET['post'];
        $data['body'] = $_POST['comment-body'];
        $data['userId'] = $post->userIdFromPost($postId);

        $validate = new Validator();

        // Required Fields

        $field_array = array('body');

        if($validate->isRequired($field_array))
        {
            die($post->reply($data));
            if($post->reply($data))
            {
                // redirect('post.php?post='.$postId, 'Your reply has been posted.', 'success');
                redirect('index.php', 'Your reply has been posted.', 'success');
            }
            else
            {
                // redirect('post.php?post='.$postId, 'Something went wrong, Please try again.', 'error');
                redirect('index.php', 'Something went wrong, Please try again.', 'error');
            }
        }
        else
            // redirect('post.php?post='.$postId, 'Cannot reply a blank comment', 'error');
            redirect('index.php', 'Cannot reply a blank comment', 'error');

    }

    echo $template;

?>