<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;

class FixSlugsSeeder extends Seeder
{
    public function run()
    {
        $services = Service::whereNull('slug')->orWhere('slug', '')->get();
        foreach($services as $s) {
            $s->update(['slug' => Str::slug($s->title)]);
        }
    }
}
