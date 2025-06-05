<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enums\JobPostStatus;
use App\Enums\EmploymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $description
 * @property string $location
 * @property EmploymentType $employment_type
 * @property JobPostStatus $status
 * @property int $user_id
 * @property int $employer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employer|null $employer
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereEmploymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereEmployerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobPost whereUserId($value)
 * @mixin \Eloquent
 */
class JobPost extends Model
{
    /**
     * Interact with the job post's description.
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => trim(
                html_entity_decode($value)
            ),
            set: fn(string $value) => htmlentities($value),
        );
    }

    public function companyName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->employer?->name,
        );
    }

    public function casts(): array
    {
        return [
            'employment_type' => EmploymentType::class,
            'status' => JobPostStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', JobPostStatus::APPROVED);
    }

    protected static function booted(): void
    {
        static::creating(function (JobPost $jobPost) {
            $jobPost->uuid = Str::uuid()->toString();
        });
    }
}
