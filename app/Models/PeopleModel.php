<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/27
 * Time: 0:29
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PeopleModel extends Model{
    protected $table = 'people';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name', 'sex', 'wife'];
    protected $hidden = ['updatedAt', 'createdAt'];


    public static function add(array $data = [])
    {
        if ($result = static::create($data))
        {
            return static::getOne($result['prizeId']);
        }

        return $result;
    }

    public static function del($prizeId, array $filters = [])
    {
        if ($result = static::destroy($prizeId))
        {
            return true;
        }

        return false;
    }
    public static function getOne($id, array $filters = [])
    {
        $result = static::where('people.id', '=', $id);

        foreach ($filters as list($field, $operator, $value))
        {
            $result->where('prize.' . $field, $operator, $value);
        }

        return $result->get();
    }

    public static function getMul(array $prizeIds = [], array $filters = [])
    {
        $result = static::whereIn('prize.prizeId', $prizeIds);

        foreach ($filters as list($field, $operator, $value))
        {
            $result->where('prize.' . $field, $operator, $value);
        }

        return $result->get();
    }

}