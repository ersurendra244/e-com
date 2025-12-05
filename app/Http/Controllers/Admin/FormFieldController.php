<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormField;
use App\Models\Category;

class FormFieldController extends Controller
{
    public function index()
    {
        $fields = FormField::with('subcategory')->orderBy('order_no')->get();
        return view('admin.form_fields.index', compact('fields'));
        $data['title'] = 'Form Field List';
        $data['subtitle'] = 'subcategory';
        $data['form_fields'] = FormField::with('subcategory')->orderBy('order_no')->where('is_delete', '0')->get();
        return view('admin.sub_categories.form_fields', $data);
    }

    public function create()
    {
        $subcategories = Category::whereNotNull('parent_id')->get();
        return view('admin.form_fields.create', compact('subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subcategory_id' => 'required|integer',
            'field_label' => 'required|string|max:255',
            'field_name' => 'required|string|max:255|unique:form_fields,field_name',
            'field_type' => 'required|string',
            'field_options' => 'nullable|array',
            'is_required' => 'boolean',
            'order_no' => 'nullable|integer',
        ]);

        if (!empty($data['field_options'])) {
            $data['field_options'] = json_encode($data['field_options']);
        }

        FormField::create($data);

        return redirect()->route('admin.form_fields.index')->with('success', 'Form field added successfully!');
    }

    public function edit(FormField $form_field)
    {
        $subcategories = Category::whereNotNull('parent_id')->get();
        return view('admin.form_fields.edit', compact('form_field', 'subcategories'));
    }

    public function update(Request $request, FormField $form_field)
    {
        $data = $request->validate([
            'subcategory_id' => 'required|integer',
            'field_label' => 'required|string|max:255',
            'field_name' => 'required|string|max:255|unique:form_fields,field_name,' . $form_field->id,
            'field_type' => 'required|string',
            'field_options' => 'nullable|array',
            'is_required' => 'boolean',
            'order_no' => 'nullable|integer',
        ]);

        if (!empty($data['field_options'])) {
            $data['field_options'] = json_encode($data['field_options']);
        }

        $form_field->update($data);

        return redirect()->route('admin.form_fields.index')->with('success', 'Form field updated successfully!');
    }

    public function destroy(FormField $form_field)
    {
        $form_field->delete();
        return redirect()->route('admin.form_fields.index')->with('success', 'Form field deleted!');
    }
}
