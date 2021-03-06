<?php

namespace App;

use App\Scripts\php\Data;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/*
* @property string $nom
* @property date $last_update
 * @package App\Models
* @mixin Builder
*/
class MediaInfo extends Model
{
    public $table = "media_info";
    public $timestamps = false;
    protected $fillable = ['name','last_update'];

    public function article(){
        return $this->hasMany(Article::class, 'name', 'media');
    }

    public static function InsertMedia(){
        $medias = DB::table('articles')->select('media as name')->groupBy('media')->get()->pluck('name');
        $data = [];
        foreach ($medias as $media){
            $data[] = ['name'=> $media,'last_update'=>null,];
        }
        return DB::table('media_info')->insertOrIgnore($data);
    }
}
