<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('exam_questions') || !Schema::hasTable('exam_categories') || !Schema::hasTable('exam_difficulty_levels')) {
            return;
        }

        if (!Schema::hasColumn('exam_questions', 'difficulty_level_id')) {
            return;
        }

        $ownerIds = DB::table('exam_questions')
            ->join('exam_categories', 'exam_questions.category_id', '=', 'exam_categories.id')
            ->whereNull('exam_questions.difficulty_level_id')
            ->select('exam_categories.user_id')
            ->distinct()
            ->pluck('user_id');

        foreach ($ownerIds as $userId) {
            $difficultyId = $this->defaultDifficultyLevelId($userId);

            DB::table('exam_questions')
                ->join('exam_categories', 'exam_questions.category_id', '=', 'exam_categories.id')
                ->whereNull('exam_questions.difficulty_level_id')
                ->where(function ($query) use ($userId) {
                    if ($userId === null) {
                        $query->whereNull('exam_categories.user_id');
                    } else {
                        $query->where('exam_categories.user_id', $userId);
                    }
                })
                ->update(['exam_questions.difficulty_level_id' => $difficultyId]);
        }
    }

    public function down(): void
    {
        //
    }

    private function defaultDifficultyLevelId(?int $userId): int
    {
        $existing = DB::table('exam_difficulty_levels')
            ->where('name', 'Media')
            ->where(function ($query) use ($userId) {
                if ($userId === null) {
                    $query->whereNull('user_id');
                } else {
                    $query->where('user_id', $userId);
                }
            })
            ->value('id');

        if ($existing) {
            return (int) $existing;
        }

        return (int) DB::table('exam_difficulty_levels')->insertGetId([
            'name' => 'Media',
            'points' => 5,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
