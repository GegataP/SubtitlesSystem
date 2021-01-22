<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Filesystem\FilesystemManager;


class Subtitles extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subtitles';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('public')->delete($obj->subsfile);
        });
    }

    public function setFileAttribute($value)
    {
        $attribute_name = "subsfile";
        $disk = "public";
        $destination_path = "public/subtitles";

        $this->uploadFileToDisk($value, 'subsfile', 'public', 'public/subtitles');

        // return $this->attributes[{$attribute_name}]; // uncomment if this is a translatable field

    {
        // if a new file is uploaded, delete the file from the disk
        if (request()->hasFile('subsfile') &&
            $this->{'subsfile'} &&
            $this->{'subsfile'} != null) {
            \Storage::disk('public')->delete($this->{'subsfile'});
            $this->attributes['subsfile'] = null;
        }

        // if the file input is empty, delete the file from the disk
        if (is_null($value) && $this->{'subsfile'} != null) {
            \Storage::disk($disk)->delete($this->{'subsfile'});
            $this->attributes['subsfile'] = null;
        }

        // if a new file is uploaded, store it on disk and its filename in the database
        if (request()->hasFile('subsfile') && request()->file('subsfile')->isValid()) {
            // 1. Generate a new file name
            $file = request()->file('subsfile');
            $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

            // 2. Move the new file to the correct path
            $file_path = $file->storeAs('public/subtitles', $new_file_name, 'public');

            // 3. Save the complete path to the database
            $this->attributes['subsfile'] = $file_path;
        }
    }
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'subtitles_movies','subtitles_id', 'movie_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
