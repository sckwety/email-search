<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailSearchPostRequest;
use App\Models\EmailSearchRequest;
use App\Models\EmailSearchResult;
use App\Services\ProviderService;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class EmailSearchController extends Controller
{

    /**
     * @return View|Factory|Application
     */
    public function searchForm(): View|Factory|Application
    {
        return view('emails-search/form');
    }

    /**
     * @param EmailSearchPostRequest $request
     * @return RedirectResponse
     * @throws \App\Exceptions\ProviderErrorException
     */
    public function search(ProviderService $providerService, EmailSearchPostRequest $request): RedirectResponse
    {
        $emailSearchRequest = EmailSearchRequest::firstOrCreate([
            'name' => $request->input('name'),
            'company' => $request->input('company'),
            'linkedin_profile_url' => $request->input('linkedInProfileUrl'),
        ]);

        $providerIndex = $this->getProviderIndex($emailSearchRequest);
        if (null === $providerIndex) {
            return redirect()->back()->withInput($request->input())
                ->with('error', 'The list of providers is depleted. This profile cannot be searchable again.');
        }

        for ($i = $providerIndex; $i < count(config('providers')); $i++) {
            $providerService->setConfig(config('providers.' . $i));
            $providerService->setClient();
            $result = $providerService->search($request);
            if(!empty($result)) {
                break;
            }
        }

        if(empty($result)) {
            return redirect()->back()->withInput($request->input())
                ->with('error', 'No email found. You can try again.');
        }

        EmailSearchResult::create([
            'email_search_request_id' => $emailSearchRequest->id,
            'provider_index' => $i,
            'result' => json_encode($result),
        ]);

        return redirect()->back()->withInput($request->input())
            ->with('success', 'Emails Found in provider ' . $i . ':')
            ->with('result', $result);
    }

    /**
     * @param EmailSearchRequest $emailSearchRequest
     * @return int|null
     */
    private function getProviderIndex(EmailSearchRequest $emailSearchRequest): int|null
    {
        $defaultProviderIndex = 0;
        $lastProviderIndex = $emailSearchRequest->emailSearchResults()
            ->orderBy('id', 'desc')
            ->value('provider_index');

        if (null === $lastProviderIndex) {
            return $defaultProviderIndex;
        }

        $nextProviderIndex = $lastProviderIndex + 1;
        if ($nextProviderIndex < count(config('providers'))) {
            return $nextProviderIndex;
        }

        return null;
    }
}
