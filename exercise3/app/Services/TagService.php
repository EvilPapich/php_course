<?php


namespace App\Services;


use App\Models\Tag;

class TagService
{
  public static function mergeTags(?Array $tags) {
    $result = [];

    foreach ($tags as $index => $item) {
      $tag = Tag::updateOrCreate(['name' => $item]);

      $tag->save();

      $result[$index] = [
        'id' => $tag->id,
        'name' => $item,
      ];
    }

    return collect($result);
  }
}