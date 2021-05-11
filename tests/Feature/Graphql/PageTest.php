<?php

namespace Tests\Feature;

use Tests\TestCase;
use DrewRoberts\Blog\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function testGetOnePage()
    {
        $page = Page::factory()->create();

        $response = $this->graphQL('
            query page($id: Int!) {
                page(id: $id) {
                    id,
                    slug,
                    title,
                    is_location,
                    is_leaf,
                    is_root,
                    is_only_child,
                    is_only_root_location,
                    path,
                    depth,
                    content,
                    pageviews,
                    description,
                    ogdescription,
                    published_at,
                    deleted_at,
                    created_at,
                    updated_at,
                    webpage_id,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                }
            } ', ['id' => $page->id]);

        $response->assertJson([
            'data' => [
                'page' => [
                    'id' => $page->id,
                    'slug' => $page->slug,
                    'title' => $page->title,
                    'is_location' => $page->is_location,
                    'is_leaf' => $page->is_leaf,
                    'is_root' => $page->is_root,
                    'is_only_child' => $page->is_only_child,
                    'is_only_root_location' => $page->is_only_root_location,
                    'path' => $page->path,
                    'depth' => $page->depth,
                    'content' => $page->content,
                    'pageviews' => $page->pageviews,
                    'description' => $page->description,
                    'ogdescription' => $page->ogdescription,
                    'published_at' => $page->published_at,
                    'deleted_at' => $page->deleted_at,
                    'created_at' => $page->created_at,
                    'updated_at' => $page->updated_at,
                    'webpage_id' => $page->webpage_id,
                    'image_id' => $page->image_id,
                    'ogimage_id' => $page->ogimage_id,
                    'video_id' => $page->video_id,
                    'creator_id' => $page->creator_id,
                    'updater_id' => $page->updater_id
                ]
            ]
        ]);
    }

    public function testGetAllPages()
    {
        $pages = Page::factory()->count(10)->create();

        $query = '{
            pages(first: 10) {
                data {
                    id,
                    slug,
                    title,
                    is_location,
                    is_leaf,
                    is_root,
                    is_only_child,
                    is_only_root_location,
                    path,
                    depth,
                    content,
                    pageviews,
                    description,
                    ogdescription,
                    published_at,
                    deleted_at,
                    created_at,
                    updated_at,
                    webpage_id,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                }
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
                'pages' => [
                    'data' => [
                        [
                            'id' => $pages->first()->id,
                            'slug' => $pages->first()->slug,
                            'title' => $pages->first()->title,
                            'is_location' => $pages->first()->is_location,
                            'is_leaf' => $pages->first()->is_leaf,
                            'is_root' => $pages->first()->is_root,
                            'is_only_child' => $pages->first()->is_only_child,
                            'is_only_root_location' => $pages->first()->is_only_root_location,
                            'path' => $pages->first()->path,
                            'depth' => $pages->first()->depth,
                            'content' => $pages->first()->content,
                            'pageviews' => $pages->first()->pageviews,
                            'description' => $pages->first()->description,
                            'ogdescription' => $pages->first()->ogdescription,
                            'published_at' => $pages->first()->published_at,
                            'deleted_at' => $pages->first()->deleted_at,
                            'created_at' => $pages->first()->created_at,
                            'updated_at' => $pages->first()->updated_at,
                            'webpage_id' => $pages->first()->webpage_id,
                            'image_id' => $pages->first()->image_id,
                            'ogimage_id' => $pages->first()->ogimage_id,
                            'video_id' => $pages->first()->video_id,
                            'creator_id' => $pages->first()->creator_id,
                            'updater_id' => $pages->first()->updater_id
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
