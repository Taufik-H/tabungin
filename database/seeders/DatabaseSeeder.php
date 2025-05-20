<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Discussion;
use App\Models\Comment;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);
        
        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole($userRole);
        
        // Create categories
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'Latest technology news and discussions',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Design',
                'description' => 'UI/UX design trends and inspirations',
                'color' => '#8B5CF6',
            ],
            [
                'name' => 'Development',
                'description' => 'Programming and software development',
                'color' => '#10B981',
            ],
            [
                'name' => 'Business',
                'description' => 'Business strategies and entrepreneurship',
                'color' => '#F59E0B',
            ],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
        
        // Create blog posts
        for ($i = 1; $i <= 10; $i++) {
            $post = Post::create([
                'user_id' => $admin->id,
                'category_id' => rand(1, 4),
                'title' => "Sample Blog Post $i",
                'slug' => "sample-blog-post-$i",
                'excerpt' => "This is a sample excerpt for blog post $i",
                'content' => "# Sample Blog Post $i\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\n\n## Heading 2\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\n- List item 1\n- List item 2\n- List item 3",
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
            
            // Add some comments to posts
            for ($j = 1; $j <= rand(2, 5); $j++) {
                $comment = Comment::create([
                    'user_id' => $user->id,
                    'commentable_id' => $post->id,
                    'commentable_type' => Post::class,
                    'content' => "This is comment $j on the blog post. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                ]);
                
                // Add a reply to some comments
                if (rand(0, 1)) {
                    Comment::create([
                        'user_id' => $admin->id,
                        'commentable_id' => $post->id,
                        'commentable_type' => Post::class,
                        'parent_id' => $comment->id,
                        'content' => "This is a reply to comment $j. Thank you for your feedback!",
                    ]);
                }
            }
        }
        
     // Create forum discussions
for ($i = 1; $i <= 15; $i++) {
    $isPinned = $i <= 2; // First two discussions are pinned

    $discussion = Discussion::create([
        'user_id' => $i % 2 === 0 ? $admin->id : $user->id,
        'category_id' => rand(1, 4),
        'title' => "Discussion Topic $i",
        'slug' => "discussion-topic-$i",
        'content' => "# Discussion Topic $i\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.\n\n## My Question\n\nDuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\n\n- Point 1\n- Point 2\n- Point 3",
        'view_count' => rand(10, 200),
        'is_pinned' => $isPinned,
        'is_locked' => $i === 3, // Third discussion is locked
    ]);

    // Add some comments to discussions
    for ($j = 1; $j <= rand(3, 8); $j++) {
        $comment = Comment::create([
            'user_id' => rand(0, 1) ? $admin->id : $user->id,
            'commentable_id' => $discussion->id,
            'commentable_type' => Discussion::class,
            'content' => "This is comment $j on the discussion. Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
        ]);

        // Add some likes using firstOrCreate to avoid duplicate entry error
        if (rand(0, 1)) {
            $discussion->likes()->firstOrCreate([
                'user_id' => $admin->id,
                'likeable_id' => $discussion->id,
                'likeable_type' => Discussion::class,
            ]);
        }

        if (rand(0, 1)) {
            $discussion->likes()->firstOrCreate([
                'user_id' => $user->id,
                'likeable_id' => $discussion->id,
                'likeable_type' => Discussion::class,
            ]);
        }

        // Add a reply to some comments
        if (rand(0, 1)) {
            Comment::create([
                'user_id' => rand(0, 1) ? $admin->id : $user->id,
                'commentable_id' => $discussion->id,
                'commentable_type' => Discussion::class,
                'parent_id' => $comment->id,
                'content' => "This is a reply to comment $j. I have a different perspective on this.",
            ]);
        }
    }
}

    }
}