<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Models\Faqs;
use App\Http\Requests\Admin\FaqsRequest;

class FaqsController extends Controller
{
  public function __construct(private Faqs $faqs)
  {
  }

  public function index()
  {
    try {
      $faqs = $this->faqs
        ->orderBy('created_at', 'desc')
        ->paginate(10);

      if (request()->ajax()) {
        return response()->json([
          'table' => view('components.tables.faqs', ['records' => $faqs])->render(),
          'form' => view('components.forms.faqs', ['record' => new Faqs()])->render(),
        ], 200);
      }

      return View::make('admin.faqs.index')
        ->with('records', $faqs)
        ->with('record', new Faqs());

    } catch (\Exception $e) {
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function create()
  {
    try {
      if (request()->ajax()) {
        return response()->json([
          'form' => view('components.forms.faqs', ['record' => new Faqs()])->render(),
        ], 200);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function store(FaqsRequest $request)
  {
    try {
      $data = $request->validated();

      $this->faqs->updateOrCreate(
        ['id' => $request->input('id')],
        $data
      );

      $faqs = $this->faqs
        ->orderBy('created_at', 'desc')
        ->paginate(10);

      $message = $request->filled('id')
        ? \Lang::get('admin/notification.update')
        : \Lang::get('admin/notification.create');

      return response()->json([
        'table' => view('components.tables.faqs', ['records' => $faqs])->render(),
        'form' => view('components.forms.faqs', ['record' => new Faqs()])->render(),
        'message' => $message,
      ], 200);

    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage(),
      ], 500);
    }
  }

  public function edit(Faqs $faqs)
  {
    try {
      return response()->json([
        'form' => view('components.forms.faqs', ['record' => $faqs])->render(),
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }

  public function destroy(Faqs $faqs)
  {
    try {
      $faqs->delete();

      $faqs = $this->faqs
        ->orderBy('created_at', 'desc')
        ->paginate(10);

      return response()->json([
        'table' => view('components.tables.faqs', ['records' => $faqs])->render(),
        'form' => view('components.forms.faqs', ['record' => new Faqs()])->render(),
        'message' => \Lang::get('admin/notification.destroy'),
      ], 200);

    } catch (\Exception $e) {
      return response()->json([
        'message' => \Lang::get('admin/notification.error'),
      ], 500);
    }
  }
}
