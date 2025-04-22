<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::create([
            'title' => 'The Pioneers of Psychotherapy Lived Long, Productive Lives',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, eiquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in erepre ahenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur etascisint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'user_id' => 1,
            'created_at' => '2024-12-18 00:17:11',
        ]);

        Blog::create([
            'title' => 'Understanding Obsessive Compulsive Disorder (OCD)',
            'description' => 'OCD is often misunderstood in popular culture. It is commonly simplified and portrayed in media as obsession with cleanliness or order i.e. handwashing or arranging objects on a specific way, but there is a much more nuanced spectrum that OCD can manifest itself.
                              What is OCD?
                              Technically speaking, OCD is characterized by recurrent and persistent unwanted thoughts, images, or bodily sensations that provoke significant anxiety or high distress. As a response to this distress, the individual engages in repetitive acts, otherwise known as compulsions. These repetitive acts function to reduce the distress caused by the obsessions.',
            'user_id' => 1,
            'created_at' => '2025-04-7 00:17:11',
        ]);

        Blog::create([
            'title' => 'What is Complex Post-Traumatic Stress Disorder?',
            'description' => 'Post-Traumatic Stress Disorder (PTSD) is a well-known mental health condition that arises from experiencing or witnessing a traumatic event. However, a lesser-known but equally significant condition, Complex PTSD (C-PTSD), occurs when an individual endures prolonged or repeated trauma, particularly in interpersonal contexts. Understanding the distinction between PTSD and C-PTSD, recognizing symptoms, and exploring treatment options is essential for individuals seeking healing and support. Often times CPTSD is mis diagnosed, as symptoms like anxiety and depression come with it.',
            'user_id' => 1,
            'created_at' => '2025-04-22 00:17:11',
        ]);
    }
}
