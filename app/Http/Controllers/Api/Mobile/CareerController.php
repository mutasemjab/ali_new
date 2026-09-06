<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerApply;
use App\Models\CareerSpecification;
use App\Models\Store;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * GET /stores/{store}/careers — open job listings, each with the dynamic
     * fields the client must fill out to apply (rendered client-side).
     */
    public function index(Store $store)
    {
        $careers = Career::where('store_id', $store->id)
            ->with('specifications.values')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Careers retrieved successfully',
            'data' => $careers->map(fn (Career $career) => $this->careerSummary($career)),
        ]);
    }

    /**
     * POST /stores/{store}/careers/{career}/apply (auth:sanctum)
     * multipart/form-data: answers[{specification_id}] = text value, or an uploaded file for file-type fields.
     */
    public function apply(Request $request, Store $store, Career $career)
    {
        if ((int) $career->store_id !== (int) $store->id) {
            return response()->json(['status' => false, 'message' => 'Career not found', 'data' => null], 404);
        }

        $client = $request->user();

        $alreadyApplied = CareerApply::where('career_id', $career->id)
            ->where('client_id', $client->id)
            ->exists();

        if ($alreadyApplied) {
            return response()->json(['status' => false, 'message' => 'You have already applied for this career', 'data' => null], 422);
        }

        $specifications = $career->specifications;

        $rules = [];
        foreach ($specifications as $spec) {
            $rule = $spec->is_required ? 'required' : 'nullable';
            $rule .= $spec->type == CareerSpecification::TYPE_FILE ? '|file|max:10240' : '|string|max:1000';
            $rules['answers.'.$spec->id] = $rule;
        }

        $request->validate($rules);

        foreach ($specifications as $spec) {
            $key = "answers.{$spec->id}";

            if ($spec->type == CareerSpecification::TYPE_FILE) {
                if (! $request->hasFile($key)) {
                    continue;
                }

                $filename = uploadImage('assets/uploads/career-applies', $request->file($key));
                $value = 'assets/uploads/career-applies/'.$filename;
            } else {
                $value = $request->input($key);

                if ($value === null) {
                    continue;
                }
            }

            CareerApply::create([
                'client_id' => $client->id,
                'career_id' => $career->id,
                'career_specification_id' => $spec->id,
                'value' => $value,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Application submitted successfully',
            'data' => null,
        ]);
    }

    private function careerSummary(Career $career): array
    {
        return [
            'id' => $career->id,
            'title' => $career->title,
            'description' => $career->description,
            'specifications' => $career->specifications->map(fn (CareerSpecification $spec) => [
                'id' => $spec->id,
                'name' => $spec->name,
                'type' => $spec->type_label,
                'required' => $spec->is_required,
                'values' => $spec->values->pluck('value')->values(),
            ]),
        ];
    }
}
