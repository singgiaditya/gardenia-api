<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('/register', 'UsersController::register');
$routes->post('/login', 'UsersController::login');

$routes->group('post', ['filter' => 'jwtAuth'], function ($routes) {
    $routes->get('', 'PostsController::index');
    $routes->post('', 'PostsController::create');
    $routes->put('/(:num)', 'PostsController::update/$1');
    $routes->delete('(:num)', 'PostController::delete/$1');

});



$routes->group('comments', ['filter' => 'jwtAuth'], function ($routes) {
    // Comments
    $routes->post('', 'CommentsController::create');                 // Create a new comment
    $routes->get('', 'CommentsController::index');                  // Retrieve all comments
    $routes->get('(:num)', 'CommentsController::show/$1');          // Retrieve a specific comment
    $routes->get('post/(:num)', 'CommentsController::showByPostId/$1'); // Retrieve comments by post_id
    $routes->put('(:num)', 'CommentsController::update/$1');        // Update a specific comment
    $routes->delete('(:num)', 'CommentsController::delete/$1');    // Delete a specific comment
});


$routes->group('likes', ['filter' => 'jwtAuth'], function ($routes) {
    $routes->post('', 'LikeController::create');
    $routes->get('', 'LikeController::index');
    $routes->get('/post/(:num)', 'LikeController::show/$1'); //showByPost
    $routes->delete('/(:num)', 'LikeController::delete/$1');
});

$routes->group('following', ['filter' => 'jwtAuth'], function ($routes) {
    $routes->post('', 'FollowingController::create');
    $routes->get('', 'FollowingController::index');
    $routes->get('/followers/(:num)', 'FollowingController::showFollowers/$1');
    $routes->get('/(:num)', 'FollowingController::showFollowing/$1');
    $routes->delete('/(:num)', 'FollowingController::delete/$1');
});