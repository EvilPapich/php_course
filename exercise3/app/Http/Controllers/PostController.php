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

  public function getRecentPostsWithParams(Request $request) {
    $body = $request->json();

    $filters = $body->get('filters');
    $orders = $body->get('orders');
    $tags = $body->get('tags');

    $posts = PostService::getRecentPostsWithParams($filters, $orders, $tags);

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

  public function writeComment(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'postId' => ['required'],
      'message' => ['required'],
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $postId = $body->get('postId');
    $referenceId = $body->get('referenceId');
    $message = $body->get('message');

    PostService::writeComment($postId, $author->id, $referenceId, $message);

    return json_encode([]);
  }

  public function rateComment(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'commentId' => ['required'],
      'value' => ['required', 'in:0,1'],
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $commentId = $body->get('commentId');
    $value = $body->get('value');

    PostService::rateComment($commentId, $author->id, $value);

    return json_encode([]);
  }

  public function editComment(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'commentId' => ['required'],
      'message' => ['required'],
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $commentId = $body->get('commentId');
    $message = $body->get('message');

    PostService::editComment($commentId, $author->id, $message);

    return json_encode([]);
  }

  public function deleteComment(Request $request) {
    $userId = $request->header(User::USER_ID_HEADER);

    $author = AuthorService::getAuthorByUserId($userId);

    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'commentId' => ['required'],
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $commentId = $body->get('commentId');

    PostService::deleteComment($commentId, $author->id);

    return json_encode([]);
  }
}