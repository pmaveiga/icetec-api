<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Technology;
use App\Transformers\ApplicantTransform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ApplicantController extends Controller
{
    private $fractal;

    public function __construct() {
        $this->fractal = new Manager();
    }

    public function get($id) {
        $resource = new Item(Applicant::find($id), new ApplicantTransform());
        return $this->fractal->createData($resource)->toJson();
    }

    public function getAll() {
        $fractal = new Manager();
        $resource = new Collection(Applicant::all(), new ApplicantTransform());
        return $fractal->createData($resource)->toJson();
    }

    public function save(Request $request) {
        $fields = $request->all();
        $applicant = (new Applicant($fields));
        $applicant->save();
        $technologies = $request->post('technologies');
        if (!$applicant) {
            return response()->json(['message' => 'An error occurred']);
        }

        if ($technologies) {
            foreach ($technologies as $technology) {
                $applicant->technologies()->attach(Technology::find($technology));
            }
        }

        return response()->json(['message' => 'Applicant saved successfully!']);
    }

    public function put($id, Request $request) {
        $fields = $request->all();
        $applicant = Applicant::find($id);
        if (!$applicant) {
            return response()->json(['message' => "Applicant not found"], 404);
        }

        $applicant->update($fields);
        $technologies = $request->post('technologies');
        if (!$applicant) {
            return response()->json(['message' => 'An error occurred']);
        }

        if ($technologies) {
            $applicant->technologies()->detach();
            foreach ($technologies as $technology) {
                $applicant->technologies()->attach(Technology::find($technology));
            }
        }

        return response()->json(['message' => 'Applicant updated successfully!']);
    }

    public function delete($id) {
        $applicant = Applicant::find($id);
        if (!$applicant) {
            return response()->json(['message' => "Applicant not found"], 404);
        }

        $applicant->technologies()->detach();
        $applicant->delete();
        return response()->json(['message' => 'Applicant deleted successfully!']);
    }

    public function find($technologyId) {
        $technology = Technology::find($technologyId)->first();
        if (!$technology) {
            return response()->json(['message' => "Technology not found"], 404);
        }

        $applicantTechnologies = DB::table('applicant_technology')->where('technology_id', $technologyId)->get();
        $applicants = [];

        foreach($applicantTechnologies as $applicantTechnology) {
            $applicants[] = Applicant::find($applicantTechnology->applicant_id);
        }

        $resource = new Collection($applicants, new ApplicantTransform());
        return $this->fractal->createData($resource)->toJson();
    }
}
