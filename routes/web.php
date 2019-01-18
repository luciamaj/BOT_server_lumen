<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('answers',  ['uses' => 'AnswerController@showAllAnswers']);
    $router->post('answers', ['uses' => 'AnswerController@create']);

    $router->post('questions', ['uses' => 'QuestionController@create']);
    $router->post('question-user', ['uses' => 'QuestionController@createUserQ']);

    $router->get('grouped-questions',  ['uses' => 'QuestionController@showGroupedQuestions']);

    $router->post('last-question', ['uses' => 'QuestionController@getLast']);
    
    $router->post('keywords', ['uses' => 'KeywordController@create']);
    
    $router->post('query', ['uses' => 'QueryController@checkKeywords']);

    $router->post('login', 'LoginController@login');
    $router->post('register', 'UserController@register');
    $router->get('user', ['middleware' => 'auth', 'uses' =>  'UserController@get_user']);
  });
