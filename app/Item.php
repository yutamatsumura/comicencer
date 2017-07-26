<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['code', 'name', 'url', 'image_url'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('type')->withTimestamps();
    }

    public function want_users()
    {
        return $this->users()->where('type', 'want');
    }
    
    public function read_users()
    {
        return $this->users()->where('type', 'read');
    }
    
    public function reviews()
    {
        return $this->belongsToMany(Review::class);
    }
    
    
    public function item_reviews()
    {
        $reviewlist = $this->reviews()->lists('items.id')->toArray();
        $reviewlist[] = $this->id;
        
        return Review::where('item_id', $reviewlist);
    }
    
}