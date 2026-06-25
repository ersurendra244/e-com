<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IssueController extends Controller
{

    public function index()
    {
        $data['title'] = 'Issue List';
        return view('admin.issues.list', $data);
    }

    public function getIssues(Request $request)
    {
        $issueNumber = $request->input('issue_number', '');
        $status      = $request->input('status', 'All');
        $fromDate    = $request->input('from_date');
        $toDate      = $request->input('to_date');
        if ($fromDate && $toDate) {
            if (strtotime($fromDate) > strtotime($toDate)) {
                return response()->json([
                    'error' => 'Invalid date range'
                ], 400);
            }

            $fromDate = date('Y-m-d', strtotime($fromDate));
            $toDate   = date('Y-m-d', strtotime($toDate));
        } else {
            // $fromDate = date('Y-m-d', strtotime('-30 days'));
            // $toDate   = date('Y-m-d');
            $fromDate = '';
            $toDate   = '';
        }
        $start  = $request->input('start', 0);
        $length = $request->input('length', 10);
        $draw   = $request->input('draw', 1);

        $page = ($start / $length) + 1;

        $url = "https://cleanair.bihar.gov.in/api/v1/issues/issue_status_for_third_party";

        $postData = [
            "dateFrom" => $fromDate,
            "dateTo" => $toDate,
            "status" => $status,
            "mode" => "Air Pollution",
            "complaint_number" => $issueNumber,
            "current_page" => $page,
            "limit" => $length
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Api-Key 1234567890abcdef',
            'Content-Type' => 'application/json'
        ])
            ->withoutVerifying()
            ->post($url, $postData);

        $responseData = $response->json();

        return response()->json([
            "success" => "Data loaded successfully",
            "draw" => $draw,
            "recordsTotal" => $responseData['pagination']['total_records'] ?? 0,
            "recordsFiltered" => $responseData['pagination']['total_records'] ?? 0,
            "data" => $responseData['dtCommon'] ?? []
        ]);
    }

    public function exportIssues(Request $request)
    {
        set_time_limit(0); // 🔥 unlimited time (important)
        ini_set('memory_limit', '1024M');

        $fileName = 'issues_data_' . date('d-m-Y') . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
            "Expires" => "0"
        ];

        $columns = [
            'Issue No',
            'Created At',
            'User Name',
            'Mobile',
            'Status',
            'Department',
            'Title',
            'Category',
            'Zone',
            'Ward',
            'Assigned To',
            'Mode',
            'Latitude',
            'Longitude',
            'Resolved At',
            'Agency',
            'Escalated',
            'Escalated At',
            'Escalated To',
            'Before Image',
            'After Image'
        ];

        $issueNumber = $request->input('issue_number', '');
        $status      = $request->input('status', 'All');
        $fromDate    = $request->input('from_date');
        $toDate      = $request->input('to_date');

        if ($fromDate && $toDate && strtotime($fromDate) > strtotime($toDate)) {
            return back()->with('error', 'Invalid date range');
        }

        $fromDate = $fromDate ? date('Y-m-d', strtotime($fromDate)) : '';
        $toDate   = $toDate ? date('Y-m-d', strtotime($toDate)) : '';

        $callback = function () use ($columns, $issueNumber, $status, $fromDate, $toDate) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $page = 1;
            $limit = 500; // 🔥 optimize
            $maxPages = 5000; // 🔥 safety limit

            do {
                $url = "https://cleanair.bihar.gov.in/api/v1/issues/issue_status_for_third_party";

                $postData = [
                    "dateFrom" => $fromDate,
                    "dateTo" => $toDate,
                    "status" => $status,
                    "mode" => "Air Pollution",
                    "complaint_number" => $issueNumber,
                    "current_page" => $page, // ✅ IMPORTANT
                    "limit" => $limit        // ✅ IMPORTANT
                ];

                try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Api-Key 1234567890abcdef',
                        'Content-Type' => 'application/json'
                    ])
                        ->withoutVerifying()
                        ->post($url, $postData);

                    if (!$response->successful()) {
                        break;
                    }

                    $responseData = $response->json();
                    $data = $responseData['dtCommon'] ?? [];

                    if (empty($data)) {
                        break;
                    }

                    foreach ($data as $row) {
                        fputcsv($file, [
                            $row['issue_number'] ?? '',
                            $row['created_at'] ?? '',
                            $row['user_name'] ?? '',
                            $row['user_mobile_number'] ?? '',
                            $row['status_name'] ?? '',
                            $row['department_name'] ?? '',
                            $row['title'] ?? '',
                            $row['category_name'] ?? '',
                            $row['zone_name'] ?? '',
                            $row['ward_name'] ?? '',
                            $row['assigned_user_name'] ?? '',
                            $row['mode'] ?? '',
                            $row['latitude'] ?? '',
                            $row['longitude'] ?? '',
                            $row['resolved_at'] ?? '',
                            $row['agency_name'] ?? '',
                            $row['is_escalated'] ?? '',
                            $row['escalated_at'] ?? '',
                            $row['escalated_to'] ?? '',
                            $row['before_image'] ?? '',
                            $row['after_image'] ?? ''
                        ]);
                    }

                    fflush($file);

                    $page++;

                    // 🔥 stop condition
                    $hasMore = count($data) == $limit;

                    // 🔥 avoid API overload
                    usleep(200000); // 0.2 sec

                } catch (\Exception $e) {
                    break;
                }
            } while ($hasMore && $page <= $maxPages);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
