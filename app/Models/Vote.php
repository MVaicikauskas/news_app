<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\VoteType;

class Vote extends Model
{
    const string COL_ID = 'id';
    const string COL_USER_ID = 'user_id';
    const string COL_POST_ID = 'post_id';
    const string COL_IP_ADDRESS = 'ip_address';
    const string COL_USER_AGENT = 'user_agent';
    const string COL_TYPE = 'type';
    const string COL_CREATED_AT = 'created_at';
    const string COL_UPDATED_AT = 'updated_at';

    const string REL_USER = 'user';
    const string REL_POST = 'post';

    protected $fillable = [self::COL_USER_ID, self::COL_POST_ID, self::COL_TYPE, self::COL_IP_ADDRESS, self::COL_USER_AGENT];

    protected $casts = [
        self::COL_TYPE => VoteType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, self::COL_USER_ID);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, self::COL_POST_ID);
    }
}
