<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductOption
 * @package App
 */
class ProductOption extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_options';

    /**
     * @var array
     */
    protected $relations = [
        'product'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'name',
        'data',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
