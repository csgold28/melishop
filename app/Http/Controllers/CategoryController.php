<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorie;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Categorie::with(['parent'])->orderBy('created_at', 'DESC')->paginate(10);
        $parent = Categorie::getParent()->orderBy('name', 'ASC')->get();

        return view('categories.index', compact('category', 'parent'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50|unique:categories'
        ]);

        $request->request->add(['slug' => $request->name]);

        Categorie::create($request->except('_token'));
        return redirect(route(category . index))->with(['success' => 'Kategori Baru Ditambahkan']);
    }
}
