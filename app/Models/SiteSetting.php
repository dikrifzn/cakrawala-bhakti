<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'footer_description',
        'address',
        'phone',
        'email',
        'admin_email',
        'manager_email',
        'instagram',
        'facebook',
        'tiktok',
        'logo_header',
        'logo_footer',
    ];
}
