<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerApply;
use App\Models\CareerSpecification;
use App\Models\CareerSpecificationValue;
use App\Models\Client;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $careers = Career::withCount('applies')
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%$s%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('store.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('store.careers.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateCareer($request);

        $career = Career::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        $this->saveSpecifications($career, $data['specifications'] ?? []);

        return redirect()->route('store.careers.index')->with('success', 'Career added successfully');
    }

    public function edit(Career $career)
    {
        $career->load('specifications.values');

        return view('store.careers.edit', compact('career'));
    }

    public function update(Request $request, Career $career)
    {
        $data = $this->validateCareer($request);

        $career->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        $this->saveSpecifications($career, $data['specifications'] ?? [], true);

        return redirect()->route('store.careers.index')->with('success', 'Career updated successfully');
    }

    public function destroy(Career $career)
    {
        $career->delete();

        return back()->with('success', 'Career deleted');
    }

    /**
     * List of clients who applied to this career, one row per client with
     * their answers to every "shown in report" specification.
     */
    public function applicants(Career $career)
    {
        $career->load('specifications');

        $reportSpecifications = $career->specifications
            ->where('available_report', CareerSpecification::REPORT_YES)
            ->values();

        $applications = CareerApply::with('client')
            ->where('career_id', $career->id)
            ->get()
            ->groupBy('client_id')
            ->map(function ($applies) {
                return [
                    'client' => $applies->first()->client,
                    'submitted_at' => $applies->max('created_at'),
                    'answers' => $applies->keyBy('career_specification_id'),
                ];
            })
            ->filter(fn ($application) => $application['client'] !== null)
            ->sortByDesc('submitted_at')
            ->values();

        return view('store.careers.applicants', compact('career', 'reportSpecifications', 'applications'));
    }

    public function showApplicant(Career $career, Client $client)
    {
        $career->load('specifications');

        $answers = CareerApply::where('career_id', $career->id)
            ->where('client_id', $client->id)
            ->get()
            ->keyBy('career_specification_id');

        if ($answers->isEmpty()) {
            abort(404);
        }

        return view('store.careers.applicant', compact('career', 'client', 'answers'));
    }

    public function destroyApplicant(Career $career, Client $client)
    {
        CareerApply::where('career_id', $career->id)->where('client_id', $client->id)->delete();

        return redirect()->route('store.careers.applicants', $career->id)->with('success', 'Application deleted');
    }

    private function validateCareer(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'specifications.*.id' => 'nullable|integer|exists:career_specifications,id',
            'specifications.*.name' => 'required_with:specifications.*.type|string|max:200',
            'specifications.*.type' => 'required_with:specifications.*.name|in:1,2,3',
            'specifications.*.validation' => 'nullable|in:required,nullable',
            'specifications.*.available_report' => 'nullable|in:1,2',
            'specifications.*.values_text' => 'nullable|string',
        ]);
    }

    /**
     * Update existing specifications in place (matched by id), create new ones,
     * and drop any that were removed from the form — cascades to their answers.
     */
    private function saveSpecifications(Career $career, array $specifications, bool $isUpdate = false): void
    {
        $keptIds = [];

        foreach ($specifications as $spec) {
            if (empty($spec['name'])) {
                continue;
            }

            $payload = [
                'career_id' => $career->id,
                'name' => $spec['name'],
                'type' => $spec['type'],
                'validation' => $spec['validation'] ?? 'nullable',
                'available_report' => $spec['available_report'] ?? CareerSpecification::REPORT_NO,
            ];

            $specification = ! empty($spec['id'])
                ? CareerSpecification::where('career_id', $career->id)->find($spec['id'])
                : null;

            if ($specification) {
                $specification->update($payload);
            } else {
                $specification = CareerSpecification::create($payload);
            }

            $keptIds[] = $specification->id;

            $specification->values()->delete();

            if ((int) $spec['type'] === CareerSpecification::TYPE_SELECT) {
                $options = preg_split('/\r\n|\r|\n/', $spec['values_text'] ?? '');

                foreach (array_filter(array_map('trim', $options)) as $value) {
                    CareerSpecificationValue::create([
                        'career_specification_id' => $specification->id,
                        'value' => $value,
                    ]);
                }
            }
        }

        if ($isUpdate) {
            $career->specifications()->whereNotIn('id', $keptIds)->delete();
        }
    }
}
