<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Konstanta numerik
    const TYPE_IZIN = 1;
    const TYPE_CUTI = 2;

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    public static function getTypeLabels(): array
    {
        return [
            self::TYPE_IZIN  => 'Izin',
            self::TYPE_CUTI  => 'Cuti',
        ];
    }

    public function getTypeLabelAttribute(): string
    {
        return self::getTypeLabels()[$this->type] ?? 'Tidak Diketahui';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            default => 'Tidak Diketahui',
        };
    }
}
