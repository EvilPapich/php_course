<?php


namespace App\Http\Controllers;


use App\Services\PostService;
use Illuminate\Http\Request;

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

    $authorId = $body->get('authorId');
    $title = $body->get('title');
    $text = $body->get('text');

    PostService::writeDraft($authorId, $title, $text);

    return json_encode([]);
  }

  public function writePost(Request $request) {
    $body = $request->json();

    $authorId = $body->get('authorId');
    $title = $body->get('title');
    $text = $body->get('text');

    PostService::writePost($authorId, $title, $text);

    return json_encode([]);
  }

  public function publishDraft(Request $request) {
    $body = $request->json();

    $postId = $body->get('postId');

    PostService::publishDraft($postId);

    return json_encode([]);
  }
}