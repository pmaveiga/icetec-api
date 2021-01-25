<?php

namespace App\Transformers;

use App\Models\Applicant;
use League\Fractal\TransformerAbstract;

class ApplicantTransform extends TransformerAbstract {
    protected $defaultIncludes = ['technologies'];

    public function transform(Applicant $entity) {
        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'age' => $entity->age,
            'linkedin' => $entity->linkedin
        ];
    }

    public function includeTechnologies(Applicant $entity) {
        return $this->collection($entity->technologies()->get(), new TechnologyTransform());
    }
}
