<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->latest()->get();
        return view('pages.central.dashboard.tenants.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.central.dashboard.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenants',
            'domain_name' => 'required|string|max:255|unique:domains,domain',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $tenant = Tenant::create($validationData);
        $tenant->domains()->create([
            'domain' => $validationData['domain_name'].'.'.config('app.domain'),
            // 'domain' => $validationData['domain_name'].'.'.$request->getHost(),
        ]);

        return redirect()->route('tenants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        $tenant->load('domains');

        return view('pages.central.dashboard.tenants.show', compact('tenant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        $tenant->load('domains');

        return view('pages.central.dashboard.tenants.edit', compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        $validationData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tenants,email,' . $tenant->id,
            'domain_name' => 'required|string|max:255|unique:domains,domain,' . $tenant->domains->first()->id,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $tenant->update([
            'name' => $validationData['name'],
            'email' => $validationData['email'],
            ...(isset($validationData['password']) ? ['password' => bcrypt($validationData['password'])] : []),
        ]);

        $tenant->domains()->first()->update([
            'domain' => $validationData['domain_name'] . '.' . config('app.domain'),
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->domains()->delete();
        $tenant->delete();

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
    }
}
