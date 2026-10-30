<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactInquiry;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Handles all public-facing portfolio pages and inquiries.
 */
class PortfolioController extends Controller
{
    /**
     * Display the main landing / overview page.
     */
    public function index()
    {
        $projects = Project::displayOrder()->get();
        $categories = $projects->pluck('category')->unique()->values();
        $skills = Skill::displayOrder()->get()->groupBy('category');
        $featuredSkills = Skill::featured()->displayOrder()->get();

        return view('portfolio.index', compact('projects', 'categories', 'skills', 'featuredSkills'));
    }

    /**
     * Dedicated Projects Archive page with filtering and search.
     */
    public function projects(Request $request)
    {
        $query = Project::displayOrder();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->category($request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->paginate(9)->withQueryString();
        $totalCount = Project::count();

        return view('portfolio.projects', compact('projects', 'totalCount'));
    }

    /**
     * Dedicated Single Project Case Study / Detail view.
     */
    public function projectShow(string $slug)
    {
        $project = Project::with('galleryImages')->where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::where('id', '!=', $project->id)->take(3)->get();
        }

        return view('portfolio.project-show', compact('project', 'relatedProjects'));
    }

    /**
     * Dedicated Tech Stack & Skills page.
     */
    public function skills()
    {
        $allSkills = Skill::displayOrder()->get();
        $groupedSkills = $allSkills->groupBy('category');
        $totalSkills = $allSkills->count();

        return view('portfolio.skills', compact('groupedSkills', 'totalSkills'));
    }

    /**
     * Dedicated Services & Capabilities page.
     */
    public function services()
    {
        return view('portfolio.services');
    }

    /**
     * Dedicated Contact Hub page.
     */
    public function contactPage()
    {
        return view('portfolio.contact');
    }

    /**
     * Handle AJAX contact form submission.
     */
    public function contact(ContactRequest $request): JsonResponse
    {
        $message = Message::create($request->validated());

        // Dispatch email notification to admin
        try {
            Mail::to('info@shahzadlabs.com')->send(new ContactInquiry($message));
        } catch (\Exception $e) {
            // Log but don't break JSON response
            \Illuminate\Support\Facades\Log::warning('Mail delivery failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been received. The Shahzad Labs engineering team will get back to you shortly.',
        ]);
    }

    /**
     * Generate sitemap.xml for SEO.
     */
    public function sitemap()
    {
        $projects = Project::displayOrder()->get();

        return response()
            ->view('portfolio.sitemap', compact('projects'))
            ->header('Content-Type', 'application/xml');
    }
}
