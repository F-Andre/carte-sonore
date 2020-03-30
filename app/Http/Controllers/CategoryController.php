<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

  protected $category;

  public function __construct(CategoryRepository $category)
  {
    $this->category = $category;
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $categories = $this->category->getCollection();
    $categoryActive = "active";

    return view('admin.category_index', compact('categories', 'categoryActive'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $namesArray = $this->category->getColumn('name');
    $categoryActive = "active";

    return view('admin.category_create', compact('namesArray', 'categoryActive'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $categories = $this->category->getCollection();

    foreach ($categories as $category) {
      if ($category->name === $request->name) {
        return redirect()->back()->with('error', 'Ce nom de catégorie est déjà utilisé.');
      }
    }

    $creator = auth()->user()->id;
    $inputs = array_merge($request->all(), ['creator_id' => $creator]);

    $inputsStored = $this->category->store($inputs);

    if ($inputsStored) {
      return redirect(route('category.index'))->with('ok', 'La catégorie a bien été enregistrée.');
    }

    return redirect()->back()->with('error', 'Un problème est survenu lors de l\'enregistrement de la catégorie.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    $categoryActive = "active";
    return view('admin.category_show', compact('category', 'categoryActive'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    $namesArray = $this->category->getColumn('name');
    $categoryActive = "active";

    return view('admin.category_edit', compact('category', 'namesArray', 'categoryActive'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    $editor = auth()->user()->id;
    $inputs = array_merge($request->all(), ["editor_id" => $editor]);
    $categoryUpdated = $category->update($inputs);

    if ($categoryUpdated) {
      return redirect(route('category.show', $category))->with('ok', 'La catégorie a bien été mise à jour.');
    }

    return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de la catégorie.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    $categoryDestroyed = $category->destroy($category->id);

    if ($categoryDestroyed) {
      return redirect(route('category.index'))->with('ok', 'La catégorie a bien été supprimée.');
    }

    return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression de la catégorie.');
  }
}
