<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentAttempt;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;
use App\Models\Certificate;

class CertificationController extends Controller
{
    public function download(StudentAttempt $attempt)
    {
        // 1. Authorization: Ensure attempt passed and belongs to user OR requester is the instructor
        $isStudent = $attempt->user_id === auth()->id();
        $isInstructor = $attempt->evaluation->course->user_id === auth()->id();
        
        if ((!$isStudent && !$isInstructor) || !$attempt->passed) {
            abort(403);
        }

        $certificate = Certificate::where('student_attempt_id', $attempt->id)->first();

        if (!$certificate) {
             DB::transaction(function () use ($attempt) {
                 // Check if a certificate exists for this COURSE for this user, to avoid duplicates if they took multiple attempts?
                 // But logic is tied to attempt in this controller.
                 // A user might pass, fail, pass again? 
                 // Usually user gets 1 certificate per course.
                 // Check if user has certificate for course.
                 $existing = Certificate::where('user_id', $attempt->user_id)
                                ->where('course_id', $attempt->evaluation->course_id)
                                ->first();

                 if ($existing) {
                     return; 
                 }

                 $globalCount = Certificate::max('global_count') + 1;
                 $courseCount = Certificate::where('course_id', $attempt->evaluation->course_id)->max('course_count') + 1;
                 $year = date('Y');
                 
                 $code = "{$globalCount}-{$courseCount}-{$year}";

                 Certificate::create([
                     'user_id' => $attempt->user_id,
                     'course_id' => $attempt->evaluation->course_id,
                     'student_attempt_id' => $attempt->id,
                     'global_count' => $globalCount,
                     'course_count' => $courseCount,
                     'year' => $year,
                     'code' => $code,
                     'issued_at' => now(),
                 ]);
            });
            // Fetch again
             $certificate = Certificate::where('user_id', $attempt->user_id)
                                ->where('course_id', $attempt->evaluation->course_id)
                                ->first();
        }

        // 2. Data Preparation
        $data = [
            'attempt' => $attempt,
            'user' => $attempt->user,
            'evaluation' => $attempt->evaluation,
            'course' => $attempt->evaluation->course, // Assuming final exam is linked to course
            'date' => $attempt->completed_at,
            'certificate' => $certificate,
        ];

        // 3. PDF Generation
        $pdf = Pdf::loadView('certificates.course-certificate', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('certificado-' . $attempt->evaluation->course->slug . '.pdf');
    }

    public function downloadExam(\App\Models\ExamUserAttempt $attempt)
    {
        // 1. Authorization
        if ($attempt->user_id !== auth()->id() && !auth()->user()->isAdmin()) { // Assuming isAdmin helper exists or similar logic
             abort(403);
        }

        // Check for approval (flag set OR score sufficient)
        $isPassingScore = $attempt->final_score >= $attempt->evaluation->passing_score;
        
        if (!$attempt->is_approved && !$isPassingScore) {
             abort(403, 'Evaluación no aprobada.');
        }

        // 2. Data Preparation
        // Since we don't have a 'Certificate' record structure for ExamUserAttempt yet (no exams_id or similar in certificates table),
        // and ExamEvaluation doesn't explicitly link to a course, we generate a dynamic code and do not persist for now.
        // TODO: Update Certificate table to support ExamUserAttempt in the future.
        
        $year = $attempt->completed_at ? $attempt->completed_at->format('Y') : date('Y');
        $code = "EXAM-{$attempt->evaluation_id}-{$attempt->id}-{$year}";

        // Create a dummy certificate object for the view
        $certificate = new \stdClass();
        $certificate->code = $code;

        $data = [
            'attempt' => $attempt, // This is an ExamUserAttempt
            'user' => $attempt->user,
            'evaluation' => $attempt->evaluation,
            'course' => null, // View doesn't seem to use course variable directly in the layout shown
            'date' => $attempt->completed_at ?? now(),
            'certificate' => $certificate,
        ];

        // 3. PDF Generation
        // Reusing the same view. Note: The view expects a background image and specific layout.
        $pdf = Pdf::loadView('certificates.course-certificate', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('certificado-examen-' . $attempt->id . '.pdf');
    }
}
