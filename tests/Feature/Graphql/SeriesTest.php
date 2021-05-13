<?php

namespace Tests\Feature\Graphql;

use Tests\TestCase;
use DrewRoberts\Blog\Models\Topic;
use DrewRoberts\Blog\Models\Layout;
use DrewRoberts\Blog\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeriesTest extends TestCase
{
    use RefreshDatabase;

    public function testGetAllSeries()
    {
        $layout = Layout::factory()->create();
        $topic = Topic::factory()->create();
        $series = Series::factory()->hasPosts(3)->count(10)->create([
            'layout_id' => $layout->id,
            'topic_id' => $topic->id
        ]);

        $query = '{
            series(first: 10) {
                data {
                    id,
                    title,
                    slug,
                    note,
                    content,
                    webpage_id,
                    pageviews,
                    description,
                    ogdescription,
                    posts {
                        id
                    },
                    layout {
                        id
                    },
                    topic {
                        id
                    },
                    path,
                    image_id,
                    ogimage_id,
                    video_id,
                    creator_id,
                    updater_id,
                    deleted_at,
                    created_at,
                    updated_at,
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
                'series' => [
                    'data' => [
                        [
                            'id' => $series->first()->id,
                            'title' => $series->first()->title,
                            'slug' => $series->first()->slug,
                            'note' => $series->first()->note,
                            'content' => $series->first()->content,
                            'webpage_id' => $series->first()->webpage_id,
                            'pageviews' => $series->first()->pageviews,
                            'description' => $series->first()->description,
                            'ogdescription' => $series->first()->ogdescription,
                            'posts' => $series->first()->posts()->get('id')->toArray(),
                            'layout' => [
                                'id' => $series->first()->layout->id
                            ],
                            'topic' => [
                                'id' => $series->first()->topic->id
                            ],
                            'path' => $series->first()->path,
                            'image_id' => $series->first()->image_id,
                            'ogimage_id' => $series->first()->ogimage_id,
                            'video_id' => $series->first()->video_id,
                            'creator_id' => $series->first()->creator_id,
                            'updater_id' => $series->first()->updater_id,
                            'deleted_at' => $series->first()->deleted_at,
                            'created_at' => $series->first()->created_at->toDateTimeString(),
                            'updated_at' => $series->first()->updated_at->toDateTimeString()
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
