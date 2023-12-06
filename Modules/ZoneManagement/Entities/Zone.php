<?php

namespace Modules\ZoneManagement\Entities;

use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\CategoryManagement\Entities\Category;
use Modules\ProviderManagement\Entities\Provider;
use Modules\BusinessSettingsModule\Entities\Translation;

class Zone extends Model
{
    use HasFactory;
    use SpatialTrait;
    use HasUuid;

    protected $casts = [
        'is_active' => 'integer'
    ];

    protected $fillable = [];

    protected $spatialFields = [
        'coordinates'
    ];

    public function scopeOfStatus($query, $status)
    {
        $query->where('is_active', '=', $status);
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    protected function getCoordinatesAttribute($values): array
    {
        $points = [];
        foreach ($values[0] as $point) {
            $points[] = (object)['lat' => $point->getLat(), 'lng' => $point->getLng()];
        }
        return $points;
    }
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getNameAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'zone_name') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }
    protected static function booted()
    {
        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where('locale', app()->getLocale());
            }]);
        });
    }
}
