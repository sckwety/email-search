<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class ProviderErrorException extends Exception
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function render(Request $request): RedirectResponse
    {
        return redirect()->back()->withInput($request->input())->with('error', 'An error occurred, please try again.');
    }
}
