<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Validator;
use Exception;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Code for listing resources, if any
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $key
     * @return \Illuminate\Http\Response
     */
    public function create(string $key)
    {
        try {
            $page = Page::where('key', $key)->first();
            return view('admin.pages.create', compact('page'));
        } catch (Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Code for storing a new resource
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // Code for displaying a specified resource
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        // Code for editing a specified resource
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $key)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'value' => 'required|string',
        ],[
            'value.required' => 'Please enter page content',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->getMessageBag()->first()]);
        }

        try {
            $page = Page::where('key', $key)->firstOrFail();
            $page->value = $request->value;
            $page->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // Code for deleting a specified resource
    }
}
