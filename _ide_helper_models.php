<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Query\Builder|Admin onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|Admin withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Admin withoutTrashed()
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Collection[] $collections
 * @property-read int|null $collections_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nft[] $nfts
 * @property-read int|null $nfts_count
 * @method static \Database\Factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 */
	class Category extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Collection
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $category_id
 * @property int $user_id
 * @property bool $is_sensitive_content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CollectionCollaborator[] $collaborators
 * @property-read int|null $collaborators_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nft[] $nfts
 * @property-read int|null $nfts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \App\Models\SocialLink|null $socialLinks
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CollectionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Query\Builder|Collection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereIsSensitiveContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Collection whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Collection withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Collection withoutTrashed()
 */
	class Collection extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\CollectionCollaborator
 *
 * @property int $id
 * @property int $user_id
 * @property int $collection_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Collection $collection
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CollectionCollaboratorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator newQuery()
 * @method static \Illuminate\Database\Query\Builder|CollectionCollaborator onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator query()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionCollaborator whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|CollectionCollaborator withTrashed()
 * @method static \Illuminate\Database\Query\Builder|CollectionCollaborator withoutTrashed()
 */
	class CollectionCollaborator extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Kyc
 *
 * @property int $id
 * @property string $country
 * @property string $gender
 * @property string $city
 * @property string $address
 * @property string $author_type
 * @property string $status
 * @property string $author_art_type
 * @property string $phone_number
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\KycFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc newQuery()
 * @method static \Illuminate\Database\Query\Builder|Kyc onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereAuthorArtType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereAuthorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kyc whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Kyc withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Kyc withoutTrashed()
 */
	class Kyc extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * App\Models\Nft
 *
 * @property int $id
 * @property int $collection_id
 * @property int $creator_id
 * @property int $owner_id
 * @property string $file_path
 * @property string $title
 * @property string $description
 * @property float $price
 * @property string $status
 * @property bool $is_for_sale
 * @property \Illuminate\Support\Carbon|null $sale_end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Collection $collection
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $likers
 * @property-read int|null $likers_count
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Watch[] $watchers
 * @property-read int|null $watchers_count
 * @method static \Database\Factories\NftFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft isHidden()
 * @method static \Illuminate\Database\Eloquent\Builder|Nft isPublished()
 * @method static \Illuminate\Database\Eloquent\Builder|Nft newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Nft newQuery()
 * @method static \Illuminate\Database\Query\Builder|Nft onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Nft query()
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereCollectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereIsForSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereSaleEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Nft whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Nft withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Nft withoutTrashed()
 */
	class Nft extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $data
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @property int $id
 * @property string $reportable_type
 * @property int $reportable_id
 * @property int $reporter_id
 * @property string $type
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $reportable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReportableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReportableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereReporterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SocialLink
 *
 * @property int $id
 * @property string $socialable_type
 * @property int $socialable_id
 * @property string|null $facebook_url
 * @property string|null $twitter_url
 * @property string|null $instagram_url
 * @property string|null $telegram_url
 * @property string|null $website_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $socialable
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereInstagramUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereSocialableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereSocialableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereTelegramUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereTwitterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialLink whereWebsiteUrl($value)
 */
	class SocialLink extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscribe
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $subscriber
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereUserId($value)
 */
	class Subscribe extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int $nft_id
 * @property int $from
 * @property int $to
 * @property float $price
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $fromUser
 * @property-read \App\Models\Nft $nft
 * @property-read \App\Models\User $toUser
 * @method static \Database\Factories\TransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Query\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereNftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Transaction withoutTrashed()
 */
	class Transaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property string|null $email
 * @property string|null $bio
 * @property string $wallet_address
 * @property string $status
 * @property string|null $fcm_token
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $approvedFollowers
 * @property-read int|null $approved_followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Overtrue\LaravelFollow\Followable[] $approvedFollowings
 * @property-read int|null $approved_followings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Collection[] $collections
 * @property-read int|null $collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nft[] $created_nfts
 * @property-read int|null $created_nfts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Overtrue\LaravelFollow\Followable[] $followables
 * @property-read int|null $followables_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $followers
 * @property-read int|null $followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Overtrue\LaravelFollow\Followable[] $followings
 * @property-read int|null $followings_count
 * @property-read \App\Models\Kyc|null $kyc
 * @property-read \Illuminate\Database\Eloquent\Collection|\Overtrue\LaravelLike\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $notApprovedFollowers
 * @property-read int|null $not_approved_followers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Overtrue\LaravelFollow\Followable[] $notApprovedFollowings
 * @property-read int|null $not_approved_followings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nft[] $owned_nfts
 * @property-read int|null $owned_nfts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\SocialLink|null $socialLinks
 * @property-read \App\Models\Subscribe|null $subscribe
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Watch[] $watching
 * @property-read int|null $watching_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User orderByFollowersCount(string $direction = 'desc')
 * @method static \Illuminate\Database\Eloquent\Builder|User orderByFollowersCountAsc()
 * @method static \Illuminate\Database\Eloquent\Builder|User orderByFollowersCountDesc()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFcmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWalletAddress($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Spatie\MediaLibrary\HasMedia, \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App\Models{
/**
 * App\Models\Watch
 *
 * @property int $id
 * @property int $user_id
 * @property int $nft_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $watchers
 * @property-read int|null $watchers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Nft[] $watching
 * @property-read int|null $watching_count
 * @method static \Database\Factories\WatchFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Watch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Watch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Watch query()
 * @method static \Illuminate\Database\Eloquent\Builder|Watch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watch whereNftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watch whereUserId($value)
 */
	class Watch extends \Eloquent {}
}

