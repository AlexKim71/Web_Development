<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Міська рада запускає новий цифровий сервіс',
                'category' => 'Місто',
                'author' => 'Редакція',
                'content' => 'У місті представили сервіс для швидкого отримання довідок, подання звернень та перегляду новин громади.',
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Університет відкрив набір на ІТ-курси',
                'category' => 'Освіта',
                'author' => 'Анна Коваль',
                'content' => 'Студентам і всім охочим доступні курси з веброзробки, баз даних та основ програмування.',
                'published_at' => now()->subHours(10),
            ],
            [
                'title' => 'У парку з’явилася нова спортивна зона',
                'category' => 'Суспільство',
                'author' => 'Ігор Мельник',
                'content' => 'Мешканці отримали новий майданчик для тренувань, пробіжок і командних ігор просто неба.',
                'published_at' => now()->subHours(3),
            ],
        ];

        foreach ($items as $item) {
            News::query()->updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                $item + ['slug' => Str::slug($item['title'])]
            );
        }
    }
}
