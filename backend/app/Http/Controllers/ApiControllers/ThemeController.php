<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Models\Theme;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    public function index()
    {
        try {
            $themes = Theme::all();

            $data = [
                'themes' => $themes,
            ];

            return $this->jsonResponse($data, 'Themes retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve themes', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $theme = Theme::find($id);

            if (!$theme) {
                return $this->jsonResponse(null, 'Theme not found', [], false, 404);
            }

            $data = [
                'theme' => $theme,
            ];

            return $this->jsonResponse($data, 'Theme retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the theme', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'string',
            'slug' => 'string',
            'img_preview' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $theme = $request->all();

            $theme = Theme::create($theme);

            $data = [
                'theme' => $theme,
            ];

            return $this->jsonResponse($data, 'Theme created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the theme', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $theme = Theme::find($id);

        if (!$theme) {
            return $this->jsonResponse(null, 'Theme not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'package_id' => 'numeric',
            'name' => 'string',
            'price' => 'numeric',
            'description' => 'string',
            'slug' => 'string',
            'img_preview' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $theme_new = $request->all();
            
            $theme->update($theme_new);

            $data = [
                'theme' => $theme,
            ];

            return $this->jsonResponse($data, 'Theme updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the theme', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $theme = Theme::find($id);

        if (!$theme) {
            return $this->jsonResponse(null, 'Theme not found', [], false, 404);
        }

        try {
            $theme->delete();
            return $this->jsonResponse(null, 'Theme deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the theme', [$e->getMessage()], false, 500);
        }
    }
}
