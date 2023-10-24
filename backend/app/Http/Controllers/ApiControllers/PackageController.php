<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function index()
    {
        try {
            $packages = Package::all();

            $data = [
                'packages' => $packages,
            ];

            return $this->jsonResponse($data, 'Packages retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve packages', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $package = Package::find($id);

            if (!$package) {
                return $this->jsonResponse(null, 'Package not found', [], false, 404);
            }

            $data = [
                'package' => $package,
            ];

            return $this->jsonResponse($data, 'Package retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the package', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'numeric',
            'description' => 'string',
            'features' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $package = Package::create($request->all());

            $data = [
                'package' => $package,
            ];

            return $this->jsonResponse($data, 'Package created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the package', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $package = Package::find($id);

        if (!$package) {
            return $this->jsonResponse(null, 'Package not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'numeric',
            'description' => 'string',
            'features' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $package->update($request->all());

            $data = [
                'package' => $package,
            ];

            return $this->jsonResponse($data, 'Package updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the package', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $package = Package::find($id);

        if (!$package) {
            return $this->jsonResponse(null, 'Package not found', [], false, 404);
        }

        try {
            $package->delete();
            return $this->jsonResponse(null, 'Package deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the package', [$e->getMessage()], false, 500);
        }
    }
}
