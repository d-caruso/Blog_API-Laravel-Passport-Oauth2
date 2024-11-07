<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AccessTokenController;
use App\Http\Controllers\Api\Auth\ApproveAuthorizationController;
use App\Http\Controllers\Api\Auth\AuthorizationController;
use App\Http\Controllers\Api\Auth\AuthorizedAccessTokenController;
use App\Http\Controllers\Api\Auth\ClientController;
use App\Http\Controllers\Api\Auth\DenyAuthorizationController;
use App\Http\Controllers\Api\Auth\PersonalAccessTokenController;
use App\Http\Controllers\Api\Auth\ScopeController;
use App\Http\Controllers\Api\Auth\TransientTokenController;

$currentVersion = env('API_CURRENT_VERSION');

Route::prefix("{$currentVersion}")->group(function () {

    // Public auth routes
    Route::get('/authorize', [AuthorizationController::class, 'authorize']);

    Route::post('/token', [AccessTokenController::class, 'issueToken'])->name('token')->middleware('throttle');
    Route::post('/token/refresh', [TransientTokenController::class, 'refresh'])->name('token.refresh');
    Route::post('/authorize', [ApproveAuthorizationController::class, 'approve'])->name('authorizations.approve');
    Route::delete('/authorize', [DenyAuthorizationController::class, 'deny'])->name('authorizations.deny');

    // Other public routes
    Route::post('/users', [UserController::class, 'store']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('tags', [TagController::class, 'index']);
    Route::get('tags/{tag}', [TagController::class, 'show']);

    // Authenticated routes
    Route::middleware('auth:api')->group(function () {

        Route::get('user', function (Request $request) {
            return $request->user();
        });

        // Auth routes
        Route::get('/tokens', [AuthorizedAccessTokenController::class, 'forUser'])->name('tokens.index');
        Route::delete('/tokens/{token_id}', [AuthorizedAccessTokenController::class, 'destroy'])->name('tokens.destroy');
        Route::get('/clients', [ClientController::class, 'forUser'])->name('clients.index');
        Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
        Route::put('/clients/{client_id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/clients/{client_id}', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::get('/scopes', [ScopeController::class, 'all'])->name('scopes.index');
        Route::get('/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser'])->name('personal.tokens.index');
        Route::post('/personal-access-tokens', [PersonalAccessTokenController::class, 'store'])->name('personal.tokens.store');
        Route::delete('/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy'])->name('personal.tokens.destroy');

        // User routes
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::put('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);

        // Post routes
        Route::get('posts', [PostController::class, 'index']);
        Route::post('posts', [PostController::class, 'store']);
        Route::get('posts/{post}', [PostController::class, 'show']);
        Route::put('posts/{post}', [PostController::class, 'update']);
        Route::delete('posts/{post}', [PostController::class, 'destroy']);

        // Comment routes
        Route::get('comments', [CommentController::class, 'index']);
        Route::post('comments', [CommentController::class, 'store']);
        Route::get('comments/{comment}', [CommentController::class, 'show']);
        Route::put('comments/{comment}', [CommentController::class, 'update']);
        Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

        // Category routes
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

        // Tag routes
        Route::post('tags', [TagController::class, 'store']);
        Route::put('tags/{tag}', [TagController::class, 'update']);
        Route::delete('tags/{tag}', [TagController::class, 'destroy']);
    });
});