<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Attribute extends Model
{
    protected $fillable = ['name','is_filter','product_id'];
    use HasFactory,SoftDeletes;


    public function values():HasMany
    {
        return $this->hasMany(AttributeValue::class,'attribute_id');
    }
    public function canDelete():bool
    {
        $values = $this->values;
        if(!$values) return true;
        foreach($values ?? [] as $value){
            
            if($value->variations()->count() > 0){
                return false;
            }
        }
        return true;
    }
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function scopeSortByColumn(QueryBuilder|EloquentBuilder $query,array $columns = [],string $defaultColumn = 'updated_at',string $defaultSort = 'desc'):QueryBuilder|EloquentBuilder
    {
        $sort = request()->query('sort');
        $column = request()->query('column');
        if(!in_array($sort,['asc','desc'])) $sort = $defaultSort;
        if(!in_array($column,$columns)) $column = $defaultColumn;
        return $query->orderBy($column,$sort);
    }
}
