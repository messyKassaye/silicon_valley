<?php
 $path = env('HOST_NAME').'/uploads/';
return [
    'includes'=>'Likes you,Unlimited Likes,Control your profile,Skip the line,Unlimited rewinds,Swipe around the world,5 super Likes per day',
    'description'=>"See who likes before you swipe,you have unlimited right swipes! Swip until your hearts content,
    Limit what others see about you and only be shown to people you have've Liked,Be a top profile in your area for 
    30 minutes to get more matches,Accidentally swipe on some one? Rewind and swipe on them again,Match with anyone around the world,You get 5 super likes 
    per day and can increase your change to matches by 3 times",
    'images'=>$path.'likes_you.png,'.$path.'unlimited_likes.png,'.$path.'control_profile.png,'.$path.'skip_line.png,
    '.$path.'rewind.png,'.$path.'around_world.png,'.$path.'/star.png'
];