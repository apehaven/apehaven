<?php

namespace Tests\Feature\Graphql;

use Tests\TestCase;
use DrewRoberts\Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testGetOnePost()
    {
        $post = Post::factory()->create();

        $response = $this->graphQL('
            query post($id: Int!) {
                post(id: $id) {
                    id,
                    slug,
                    title,
                    content,
                    webpage_id,
                    pageviews,
                    description,
                    ogdescription,
                    published_at,
                    deleted_at,
                    created_at,
                    updated_at,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                }
            } ', ['id' => $post->id]);

        $response->assertJson([
            'data' => [
                'post' => [
                    'id' => $post->id,
                    'slug' => $post->slug,
                    'content' => $post->content,
                    'webpage_id' => $post->webpage_id,
                    'pageviews' => $post->pageviews,
                    'description' => $post->description,
                    'ogdescription' => $post->ogdescription,
                    'published_at' => $post->published_at,
                    'deleted_at' => $post->deleted_at,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'image_id' => $post->image_id,
                    'ogimage_id' => $post->ogimage_id,
                    'video_id' => $post->video_id,
                    'creator_id' => $post->creator_id,
                    'updater_id' => $post->updater_id,
                ]
            ]
        ]);
    }

    public function testGetAllPosts()
    {
        $posts = Post::factory()->count(10)->create();

        $query = '{
            posts(first: 10) {
                data {
                    id,
                    slug,
                    title,
                    content,
                    webpage_id,
                    pageviews,
                    description,
                    ogdescription,
                    published_at,
                    deleted_at,
                    created_at,
                    updated_at,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                },
                paginatorInfo {
                    currentPage
                    lastPage
                    total
                }
            }
        }';

        $response = $this->graphQL($query);

        $response->assertJson([
            'data' => [
                'posts' => [
                    'data' => [
                        [
                            'id' => $posts->first()->id,
                            'slug' => $posts->first()->slug,
                            'title' => $posts->first()->title,
                            'content' => $posts->first()->content,
                            'webpage_id' => $posts->first()->webpage_id,
                            'pageviews' => $posts->first()->pageviews,
                            'description' => $posts->first()->description,
                            'ogdescription' => $posts->first()->ogdescription,
                            'published_at' => $posts->first()->published_at,
                            'deleted_at' => $posts->first()->deleted_at,
                            'created_at' => $posts->first()->created_at,
                            'updated_at' => $posts->first()->updated_at,
                            'image_id' => $posts->first()->image_id,
                            'ogimage_id' => $posts->first()->ogimage_id,
                            'video_id' => $posts->first()->video_id,
                            'creator_id' => $posts->first()->creator_id,
                            'updater_id' => $posts->first()->updater_id,
                        ]
                    ],
                    'paginatorInfo' => [
                        'currentPage' => 1,
                        'lastPage' => 1,
                        'total' => 10
                    ]
                ]
            ]
        ]);
    }
}
