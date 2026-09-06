<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerSpecification extends Model
{
    use HasFactory;

    const TYPE_TEXT = 1;

    const TYPE_SELECT = 2;

    const TYPE_FILE = 3;

    const REPORT_YES = 1;

    const REPORT_NO = 2;

    protected $fillable = [
        'career_id', 'name', 'validation', 'type', 'available_report',
    ];

    protected $casts = [
        'type' => 'integer',
        'available_report' => 'integer',
    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function values()
    {
        return $this->hasMany(CareerSpecificationValue::class)->orderBy('id');
    }

    public function getIsRequiredAttribute(): bool
    {
        return $this->validation === 'required';
    }

    public function getTypeLabelAttribute(): string
    {
        return match ((int) $this->type) {
            self::TYPE_SELECT => 'select',
            self::TYPE_FILE => 'file',
            default => 'text',
        };
    }
}
