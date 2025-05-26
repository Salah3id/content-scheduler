<?php

namespace App\Console\Commands;

use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\PostService;
use Illuminate\Console\Command;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish scheduled posts that are due.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to publish scheduled posts...');

        $duePosts = app(PostRepositoryInterface::class)->getDuePosts();

        if ($duePosts->isEmpty()) {
            $this->info('No posts are currently due for publication.');
            return 0;
        }

        $this->info(sprintf('Found %d post(s) to publish.', $duePosts->count()));

        $allPostsSuccessfullyPublished = true;

        $postService = app(PostService::class);

        foreach ($duePosts as $post) {
            $this->info(sprintf('Processing post ID: %d, Title: %s', $post->id, $post->title));

            try {
                $posted = $postService->publish($post);
                if (!$posted) {
                    $this->error(sprintf('Post ID: %d could not be published due to no platforms being available.', $post->id));
                    $allPostsSuccessfullyPublished = false;
                    continue;
                }
            } catch (\Exception $e) {
                $this->error(sprintf('Exception while publishing post ID: %d - %s', $post->id, $e->getMessage()));
            }
        }

        if ($allPostsSuccessfullyPublished) {

            $this->info(sprintf('All %d post(s) were successfully published.', $duePosts->count()));
        } else {
            $this->error(sprintf('Some posts could not be published. Please check the logs for details.'));
        }

        $this->info('Finished publishing scheduled posts.');
        return 0;
    }
}
