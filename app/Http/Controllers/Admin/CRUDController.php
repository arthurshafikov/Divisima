<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class CRUDController extends Controller
{
    protected string $model;
    protected string $routePrefix;
    protected array $tableHeaders;
    protected array $tableData;
    protected string $title;

    public function index(): View
    {
        $posts = $this->model::orderBy('id', 'desc')->paginate(10);

        return view('admin.table', [
            'posts' => $posts,
            'title' => ucfirst($this->routePrefix) . ' Table',
            'th' => $this->tableHeaders,
            'td' => $this->tableData,
            'essence' => $this->routePrefix,
        ]);
    }

    public function create(): View
    {
        return view('admin.new.' . $this->routePrefix);
    }

    public function store(Request $request): RedirectResponse
    {
        $post = $this->model::create($this->myValidate($request));

        return redirect()->route($this->routePrefix . '.edit', $post->id)
            ->with('message', __('admin/crud.created', ['name' => $this->title]));
    }

    public function show(): RedirectResponse
    {
        return redirect()->back();
    }

    public function edit(int $id): View
    {
        $post = $this->model::findOrFail($id);

        return view('admin.edit.' . $this->routePrefix, [
            'post' => $post,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $post = $this->model::findOrFail($id);
        $post->update($this->myValidate($request));

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->title]));
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->model::destroy($id);

        return redirect()->route($this->routePrefix . '.index')
            ->with('message', __('admin/crud.deleted', ['name' => $this->title]));
    }

    protected function myValidate(Request $request): array
    {
        return [];
    }
}
