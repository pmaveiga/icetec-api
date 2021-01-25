<?php

namespace App\Transformers;

use App\Models\Technology;
use League\Fractal\TransformerAbstract;

class TechnologyTransform extends TransformerAbstract {
    public function transform(Technology $entity) {
        return [
            'id' => $entity->id,
            'name' => $entity->name
        ];
    }
}

