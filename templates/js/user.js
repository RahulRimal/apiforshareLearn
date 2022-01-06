// Follow / Unfollow User Starts Here

$(document).ready(function(){
    const searchList = new URLSearchParams(window.location.search);
    const postId = searchList.get('post');
  
    $('.follow-user-btn').click(function(){
  
      const content = $('.follow-user-btn').text();
      const userName = content.split(' ')[1];
  
      $follower = document.getElementById('followerId');
      $beingFollowed = document.getElementById('followedId');
  
      $.post('post.php?post=' + postId,
      {
        followerId: $follower.value,
        followedId: $beingFollowed.value
      }, function(data, status){
        $('.user-followers-count-text').text(data);
        $('.follow-user-btn').text('Unfollow' + ' ' + userName);
        $('.follow-user-icon').removeClass('fa-user-plus').addClass('fa-user-times');
        $('.follow-user-icon').addClass('unfollow-user-icon').removeClass('follow-user-icon');
        $('#follow-user-btn').removeClass('follow-user-btn').addClass('unfollow-user-btn');
        $('#follow-user-btn').attr("id", "unfollow-user-btn");
        // if(status === 'success'){
          // <div class="alert alert-success text-center">Your're now following this user</div>;
        // }
        // else
        // {
          // <div class="alert alert-danger text-center">Something went wrong</div>;
        // }
      });
  
    });
  
    $('.unfollow-user-btn').click(function(){
  
      const content = $('.unfollow-user-btn').text();
      const userName = content.split(' ')[1];
  
      $unfollower = document.getElementById('unfollowerId');
      $beingUnFollowed = document.getElementById('unfollowedId');
  
      $.post('post.php?post=' + postId, 
      {
        unfollowerId: $unfollower.value,
        unfollowedId: $beingUnFollowed.value
      }, function(data, status){
        $('.user-followers-count-text').text(data);
        $('.unfollow-user-btn').text('Follow' + ' ' + userName);
        $('.unfollow-user-icon').removeClass('fa-user-times').addClass('fa-user-plus');
        $('#unfollow-user-btn').removeClass('unfollow-user-btn').addClass('follow-user-btn');
        // if(status === 'success'){
          // <div class="alert alert-success text-center">Your're now following this user</div>;
        // }
        // else
        // {
          // <div class="alert alert-danger text-center">Something went wrong</div>;
        // }
      });
  
    });
  
  });
  
  // Follow / Unfollow User Ends Here