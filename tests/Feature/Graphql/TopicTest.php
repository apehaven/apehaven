<?php

namespace Tests\Feature;

use Tests\TestCase;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Layout;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TopicTest extends TestCase
{
    use RefreshDatabase;

    public function testGetOneTopic()
    {
        $layout = Layout::factory()->create();
        $topic = Topic::factory()->hasSeries(3)->create(['layout_id' => $layout->id]);

        $response = $this->graphQL('
            query topic($id: Int!) {
                topic(id: $id) {
                    id,
                    slug,
                    title,
                    note,
                    content,
                    layout {
                        id
                    },
                    series {
                        id
                    },
                    webpage_id,
                    pageviews,
                    description,
                    ogdescription,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                    deleted_at,
                    created_at,
                    updated_at,
                }
            } ', ['id' => $topic->id]);

        $response->assertExactJson([
            'data' => [
                'topic' => [
                    'id' => (string) $topic->id,
                    'slug' => $topic->slug,
                    'title' => $topic->title,
                    'note' => $topic->note,
                    'content' => $topic->content,
                    'layout' => [
                        'id' => (string) $layout->id,
                    ],
                    'series' => [
                        ['id' => '1'],
                        ['id' => '2'],
                        ['id' => '3'],
                    ],
                    'webpage_id' => $topic->webpage_id,
                    'pageviews' => $topic->pageviews,
                    'description' => $topic->description,
                    'ogdescription' => $topic->ogdescription,
                    'image_id' => $topic->image_id,
                    'ogimage_id' => $topic->ogimage_id,
                    'video_id' => $topic->video_id,
                    'creator_id' => (string) $topic->creator_id,
                    'updater_id' => (string) $topic->updater_id,
                    'deleted_at' => $topic->deleted_at,
                    'created_at' => $topic->created_at->toDateTimeString(),
                    'updated_at' => $topic->updated_at->toDateTimeString(),
                ]
            ]
        ]);
    }

    public function testGetAllTopics()
    {
        $layout = Layout::factory()->create();
        $topics = Topic::factory()->count(10)->create(['layout_id' => $layout->id]);

        $query = '{
            topics(first: 10) {
                data {
                    id,
                    slug,
                    title,
                    note,
                    content,
                    layout {
                        id
                    },
                    webpage_id,
                    pageviews,
                    description,
                    ogdescription,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                    deleted_at,
                    created_at,
                    updated_at,
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
                'topics' => [
                    'data' => [
                        [
                            'id' => $topics->first()->id,
                            'slug' => $topics->first()->slug,
                            'title' => $topics->first()->title,
                            'note' => $topics->first()->note,
                            'content' => $topics->first()->content,
                            'layout' => [
                                'id' => $layout->id,
                            ],
                            'webpage_id' => $topics->first()->webpage_id,
                            'pageviews' => $topics->first()->pageviews,
                            'description' => $topics->first()->description,
                            'ogdescription' => $topics->first()->ogdescription,
                            'image_id' => $topics->first()->image_id,
                            'ogimage_id' => $topics->first()->ogimage_id,
                            'video_id' => $topics->first()->video_id,
                            'creator_id' => $topics->first()->creator_id,
                            'updater_id' => $topics->first()->updater_id,
                            'deleted_at' => $topics->first()->deleted_at,
                            'created_at' => $topics->first()->created_at,
                            'updated_at' => $topics->first()->updated_at,
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
