<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\BlindIndex;
use App\Models\Vote;

#[Fillable([User::COL_NAME, User::COL_EMAIL, User::COL_PASSWORD, User::COL_IS_VERIFIED_BY_ADMIN, User::COL_ADMIN_VERIFIED_AT])]
#[Hidden([User::COL_PASSWORD, User::COL_REMEMBER_TOKEN])]
class User extends Authenticatable implements MustVerifyEmail, CipherSweetEncrypted
{
    const string COL_ID = 'id';
    const string COL_NAME = 'name';
    const string COL_EMAIL = 'email';
    const string COL_EMAIL_VERIFIED_AT = 'email_verified_at';
    const string COL_PASSWORD = 'password';
    const string COL_REMEMBER_TOKEN = 'remember_token';
    const string COL_IS_VERIFIED_BY_ADMIN = 'is_verified_by_admin';
    const string COL_ADMIN_VERIFIED_AT = 'admin_verified_at';
    const string COL_CREATED_AT = 'created_at';
    const string COL_UPDATED_AT = 'updated_at';

    const string REL_POSTS = 'posts';
    const string REL_VOTES = 'votes';

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, UsesCipherSweet;

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addField(self::COL_NAME)
            ->addField(self::COL_EMAIL)
            ->addBlindIndex(self::COL_EMAIL, new BlindIndex('email_index'))
            ->setPermitEmpty(true);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            self::COL_EMAIL_VERIFIED_AT => 'datetime',
            self::COL_PASSWORD => 'hashed',
        ];
    }

    /**
     * Get all of the posts for the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, Post::COL_USER_ID);
    }

    /**
     * Get all of the votes for the user.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, Vote::COL_USER_ID);
    }
}
