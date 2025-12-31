<?php

namespace App\Http\Controllers\Admin;

use App\Models\FormField;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FormFieldController extends Controller
{
    public function index()
    {
        $data['title'] = 'Form Field List';
        $data['subtitle'] = 'Masters';
        $data['form_fields'] = FormField::where('status', '1')->where('is_delete', '0')->orderBy('order')->get();
        return view('admin.form_fields.index', $data);
    }

    public function store(Request $request)
    {
        $edit_id = $request->edit_id;
        // Validation
        $validator = Validator::make($request->all(), [
            'field_label'    => 'required|string|max:255',
            'field_name'     => 'required|string|max:255|unique:form_fields,field_name,' . ($edit_id ?? 'NULL') . ',id',
            'field_type'     => 'required|string',
            'field_options'  => 'nullable|string',
            'is_required'    => 'nullable|integer',
            'order'          => 'nullable|integer',
            'status'         => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        // Prepare data
        $field_name = strtolower(str_replace(' ', '_', $request->field_name));
        $data = [
            'field_label'    => ucwords($request->field_label),
            'field_name'     => $field_name,
            'field_type'     => $request->field_type,
            'is_required'    => $request->is_required,
            'order'          => $request->order,
            'status'         => $request->status,
        ];

        // Handle field options (comma separated or array)
        if (!empty($request->field_options)) {
            $options = is_array($request->field_options)
                ? $request->field_options
                : array_map('trim', explode(',', $request->field_options));

            $data['field_options'] = json_encode($options);
        } else {
            $data['field_options'] = null;
        }

        // Create or Update
        FormField::updateOrCreate(['id' => $edit_id], $data);

        // Success message
        $msg = $edit_id
            ? 'Form field updated successfully!'
            : 'Form field created successfully!';

        Session::flash('success', $msg);
        return response()->json([
            'status'  => 'success',
            'message' => $msg,
        ]);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $data = FormField::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function delete(Request $request)
    {
        $form_field = FormField::find($request->id);
        $form_field->status = '0';
        $form_field->is_delete = '1';
        $form_field->save();
        Session::flash('success', 'Form field deleted successfully!');
        return response()->json(['success' => false]);
    }
}
