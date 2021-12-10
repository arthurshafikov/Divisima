<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class CRUDController extends Controller
{
    protected string $model;
    protected string $essense;
    protected array $th;
    protected array $td;
    protected string $oneText;

    public function index(): View
    {
        $posts = $this->model::orderBy('id', 'desc')->paginate(10);

        return view('admin.table', [
            'posts' => $posts,
            'title' => ucfirst($this->essense) . ' Table',
            'th' => $this->th,
            'td' => $this->td,
            'essence' => $this->essense,
        ]);
    }

    public function create(): View
    {
        return view('admin.new.' . $this->essense);
    }

    public function store(Request $request)
    {
        $this->myValidate($request);
        $post = $this->model::create($request->all());

        return redirect()->route($this->essense . '.edit', $post->id)
            ->with('message', __('admin/crud.created', ['name' => $this->oneText]));
    }

    public function show()
    {
        return redirect()->back();
    }

    public function edit($id): View
    {
        $post = $this->model::findOrFail($id);

        return view('admin.edit.' . $this->essense, [
            'post' => $post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->myValidate($request);
        $post = $this->model::findOrFail($id);
        $post->update($request->all());

        return redirect()->back()->with('message', __('admin/crud.updated', ['name' => $this->oneText]));
    }

    public function destroy($id)
    {
        $this->model::destroy($id);

        return redirect()->route($this->essense . '.index')
            ->with('message', __('admin/crud.deleted', ['name' => $this->oneText]));
    }

    protected function myValidate(Request $request)
    {
        return $request->validate([]);
    }
}
