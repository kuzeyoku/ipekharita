<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslation;
use App\Models\Translations\FaqTranslation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faq extends BaseModel
{
    use HasFactory, HasTranslation;

    protected $fillable = [
        'module_type',
        'service_id',
        'project_id',
        'question',
        'answer',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    /**
     * Multilingual translations relation.
     */
    public function translations(): HasMany
    {
        return $this->hasMany(FaqTranslation::class);
    }

    /**
     * Associated service if module_type is 'service'.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Associated project if module_type is 'project'.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Accessor for translated question.
     */
    public function getQuestionAttribute($value): ?string
    {
        return $this->getTranslatedAttribute('question') ?: $value;
    }

    /**
     * Accessor for translated answer.
     */
    public function getAnswerAttribute($value): ?string
    {
        return $this->getTranslatedAttribute('answer') ?: $value;
    }

    /**
     * Scope for a specific module type and optional entity ID.
     */
    public function scopeForModule(\Illuminate\Database\Eloquent\Builder $query, string $moduleType, ?int $entityId = null): \Illuminate\Database\Eloquent\Builder
    {
        $query->where('module_type', $moduleType);

        if ($entityId !== null) {
            if ($moduleType === 'service') {
                $query->where(function ($q) use ($entityId) {
                    $q->where('service_id', $entityId)->orWhereNull('service_id');
                });
            } elseif ($moduleType === 'project') {
                $query->where(function ($q) use ($entityId) {
                    $q->where('project_id', $entityId)->orWhereNull('project_id');
                });
            }
        }

        return $query;
    }

    /**
     * Human-readable label for module type.
     */
    public function getModuleTypeLabelAttribute(): string
    {
        return match ($this->module_type) {
            'service' => 'Hizmetler',
            'project' => 'Projeler',
            'general' => 'Genel',
            default   => ucfirst($this->module_type),
        };
    }
}
