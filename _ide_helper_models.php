<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $subtitle
 * @property string $image_path
 * @property string $link
 * @property string $button_text
 * @property int $order
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereButtonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Banner whereUpdatedAt($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $broadcast_category_id
 * @property string $title
 * @property string $slug
 * @property string|null $synopsis
 * @property string|null $poster
 * @property string|null $youtube_link
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BroadcastCategory $broadcastCategory
 * @property-read \App\Models\User $user
 * @property-read mixed $youtube_embed_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereBroadcastCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereSynopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Broadcast whereYoutubeLink($value)
 */
	class Broadcast extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Broadcast> $broadcasts
 * @property-read int|null $broadcasts_count
 * @property-read mixed $color_classes
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BroadcastCategory whereUpdatedAt($value)
 */
	class BroadcastCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $color_classes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $image
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereUpdatedAt($value)
 */
	class History extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string|null $link_postingan
 * @property string|null $featured_image
 * @property string|null $excerpt
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post filter(array $filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereFeaturedImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereLinkPostingan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereViews($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property int $order
 * @property string|null $image
 * @property string $content
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskFunction whereUpdatedAt($value)
 */
	class TaskFunction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string $content
 * @property string|null $image
 * @property int $order
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VisiMisi whereUpdatedAt($value)
 */
	class VisiMisi extends \Eloquent {}
}

