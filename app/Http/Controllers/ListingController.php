<?php

namespace App\Http\Controllers;

use App\Enum\CrEdit;
use App\Enum\UpDore;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index()
    {
        $filters = request(['tag', 'search']);
        return view('listings.index', [
            'listings' => Listing::latest()
                ->filter($filters)
                ->simplePaginate(6)
        ]);
    }

    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing,
        ]);
    }

    public function create()
    {
        return view('listings.edit-create', ['type' => CrEdit::CREATE]);
    }

    public function edit(Listing $listing)
    {
        return view('listings.edit-create', ['type' => CrEdit::EDIT, 'listing' => $listing]);
    }

    public function manage()
    {
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

    private function storeOrUpdate(UpDore $type, Listing|null $listing = null)
    {
        if (
            $type === UpDore::UPDATE &&
            $listing->user_id != auth()->id()
        ) {
            abort(403, 'Unauthorized');
        }

        $formFields = request()->validate([
            'title' => 'required',
            'company' => array_merge(
                ['required'],
                $type === UpDore::STORE ? [Rule::unique('listings', 'company')] : []
            ),
            'location' => 'required',
            'website' => ['required', 'url'],
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        $formFields['user_id'] = auth()->id();

        if (request()->hasFile('logo')) {
            $formFields['logo'] = request()->file('logo')->store('logos', 'public');
        }

        $message = 'Listing ' . ($type === UpDore::STORE ? 'created' : 'edited') . ' successfully!';

        if ($type === UpDore::STORE) {
            Listing::create($formFields);
            return redirect('/')->with('message', $message);
        } else {
            $listing->update($formFields);
            return back()->with('message', $message);
        }
    }

    public function store()
    {
        return self::storeOrUpdate(UpDore::STORE);
    }

    public function update(Listing $listing)
    {
        return self::storeOrUpdate(UpDore::UPDATE, $listing);
    }

    public function destroy(Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }
}
