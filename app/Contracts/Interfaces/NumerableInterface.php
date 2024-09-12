<?php

namespace App\Contracts\Interfaces;

use App\Models\GenerateNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Model<GenerateNumber> $numbers
 * @property string $getNumerableName
 * @property string|integer $getNumerableId
 */
interface NumerableInterface
{
    /**
     * Define morphToMany relationship with GenerateNumber model.
     */
    public function numbers(): MorphMany;

    /**
     * Get numerable name mapping.
     */
    public function getNumerableName(): string;

    /**
     * Get numerable id.
     */
    public function getNumerableId(): int|string;
}
