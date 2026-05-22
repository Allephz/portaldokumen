<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'data',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'data' => 'json',
        'created_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity
     */
    public static function log($action, $modelType, $modelId, $description, $data = null)
    {
        try {
            $log = self::create([
                'user_id' => auth()->id() ?? null,
                'action' => $action,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'description' => $description,
                'data' => $data,
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent')
            ]);
            \Log::info('Activity logged:', ['log_id' => $log->id, 'user_id' => auth()->id(), 'action' => $action]);
            return $log;
        } catch (\Exception $e) {
            \Log::error('Failed to log activity:', ['error' => $e->getMessage(), 'user_id' => auth()->id()]);
            return null;
        }
    }
}
