<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->ordered()->get();
        return view('faq.index', compact('faqs'));
    }

    public function adminIndex()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        Faq::create($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ добавлен');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $faq->update($request->all());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ обновлен');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ удален');
    }
}