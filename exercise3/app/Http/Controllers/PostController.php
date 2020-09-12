<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Services\AuthorService;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController
{
  public function getRecentPosts(Request $request) {
    $posts = PostService::getRecentPosts();

    return json_encode($posts);
  }

  public function getDrafts(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $posts = PostService::getDrafts($author->id);

    return json_encode($posts);
  }

  public function writeDraft(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'title' => ['required'],
      'text' => ['required'],
      'tags.*' => ['distinct']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $title = $body->get('title');
    $text = $body->get('text');
    $tags = $body->get('tags');

    PostService::writeDraft($author->id, $title, $text, $tags);

    return json_encode([]);
  }

  public function writePost(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'title' => ['required'],
      'text' => ['required'],
      'tags.*' => ['distinct']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $title = $body->get('title');
    $text = $body->get('text');
    $tags = $body->get('tags');

    PostService::writePost($author->id, $title, $text, $tags);

    return json_encode([]);
  }

  public function publishDraft(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'postId' => ['required'],
      'title' => ['required'],
      'text' => ['required'],
      'tags.*' => ['distinct']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $postId = $body->get('postId');
    $title = $body->get('title');
    $text = $body->get('text');
    $tags = $body->get('tags');

    PostService::publishDraft($postId, $author->id, $title, $text, $tags);

    return json_encode([]);
  }

  public function editDraft(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'postId' => ['required'],
      'title' => ['required'],
      'text' => ['required'],
      'tags.*' => ['distinct']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $postId = $body->get('postId');
    $title = $body->get('title');
    $text = $body->get('text');
    $tags = $body->get('tags');

    PostService::editDraft($postId, $author->id, $title, $text, $tags);

    return json_encode([]);
  }

  public function deleteDraft(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'postId' => ['required'],
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $postId = $body->get('postId');

    PostService::deleteDraft($postId, $author->id);

    return json_encode([]);
  }

  public function ratePost(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'postId' => ['required'],
      'value' => ['required', 'in:0,1']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $postId = $body->get('postId');
    $value = $body->get('value');

    PostService::ratePost($postId, $author->id, $value);

    return json_encode([]);
  }
}