<?php


namespace App\Http\Controllers;


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

  }

  public function writeDraft(Request $request) {
    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'authorId' => ['required'],
      'title' => ['required'],
      'text' => ['required'],
      'tags.*' => ['distinct']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $authorId = $body->get('authorId');
    $title = $body->get('title');
    $text = $body->get('text');
    $tags = $body->get('tags');

    PostService::writeDraft($authorId, $title, $text, $tags);

    return json_encode([]);
  }

  public function writePost(Request $request) {
    $body = $request->json();

    $validator = Validator::make($body->all(), [
      'authorId' => ['required'],
      'title' => ['required'],
      'text' => ['required'],
      'tags.*' => ['distinct']
    ]);

    if ($validator->fails()) {
      abort(400, $validator->messages());
    }

    $authorId = $body->get('authorId');
    $title = $body->get('title');
    $text = $body->get('text');
    $tags = $body->get('tags');

    PostService::writePost($authorId, $title, $text, $tags);

    return json_encode([]);
  }

  public function publishDraft(Request $request) {
    $body = $request->json();

    $postId = $body->get('postId');

    PostService::publishDraft($postId);

    return json_encode([]);
  }
}