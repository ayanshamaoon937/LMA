<?php

namespace App\Services;

use Exception;

class CmsService
{
    public function __construct(
        protected HomePageService $home,
        protected AboutPageService $about,
        protected CareersPageService $careers,
        protected ContactPageService $contact,
        protected NewsPageService $news,
        protected PrivacyPolicyPageService $privacyPolicy,
        protected ProjectPageService $project,
        protected ServicesPageService $services,
        protected TermsConditionsPageService $termsConditions
    ) {}

    /**
     * Map a route/DB slug to the appropriate page service instance.
     */
    public function getServiceForSlug(string $slug)
    {
        $normalized = strtolower(trim($slug));

        return match ($normalized) {
            'home' => $this->home,
            'about', 'about-us' => $this->about,
            'careers' => $this->careers,
            'contact', 'contact-us' => $this->contact,
            'news' => $this->news,
            'privacy-policy' => $this->privacyPolicy,
            'projects' => $this->project,
            'services' => $this->services,
            'terms-conditions', 'terms-of-use' => $this->termsConditions,
            default => throw new Exception("No CMS page service mapped for slug: '{$slug}'"),
        };
    }

    /**
     * Return all sections (including SEO metadata) for a given page slug.
     */
    public function allSections(string $slug): array
    {
        return $this->getServiceForSlug($slug)->getAllSections();
    }
}
