<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KycPartner extends Model
{
    protected $table = 'kyc_partners';

    protected $fillable = [
        'user_id',
        'name',
        'aadhaar_number',
        'aadhaar_file_id',
        'pan_number',
        'pan_file_id',
        'sort_order',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aadhaarFile()
    {
        return $this->belongsTo(File::class, 'aadhaar_file_id');
    }

    public function panFile()
    {
        return $this->belongsTo(File::class, 'pan_file_id');
    }
}
