<?php

namespace LimeSurvey\Models\Services;

use LimeSurvey\Models\Services\SurveyUpdater\{
    LanguageSettings,
    GeneralSettings,
    UrlParams,
    TemplateConfiguration
};
use LimeSurvey\Models\Services\Proxy\ProxyExpressionManager;
use LimeSurvey\Models\Services\Exception\{
    PersistErrorException,
    NotFoundException,
    PermissionDeniedException
};

/**
 * Survey Updater Service
 *
 * Service class for update survey settings.
 *
 * Dependencies are injected to enable mocking.
 */
class SurveyUpdater
{
    private LanguageSettings $languageSettings;
    private GeneralSettings $generalSettings;
    private UrlParams $urlParams;
    private ProxyExpressionManager $proxyExpressionManager;
    private TemplateConfiguration $templateConfiguration;

    public function __construct(
        LanguageSettings $languageSettings,
        GeneralSettings $generalSettings,
        UrlParams $urlParams,
        ProxyExpressionManager $proxyExpressionManager,
        TemplateConfiguration $templateConfiguration
    ) {
        $this->languageSettings = $languageSettings;
        $this->generalSettings = $generalSettings;
        $this->urlParams = $urlParams;
        $this->proxyExpressionManager = $proxyExpressionManager;
        $this->templateConfiguration = $templateConfiguration;
    }

    /**
     * Update
     *
     * @param int $surveyId
     * @param array $input
     * @throws PersistErrorException
     * @throws NotFoundException
     * @throws PermissionDeniedException
     * @return array
     */
    public function update($surveyId, $input)
    {
        $this->languageSettings->update(
            $surveyId,
            $input
        );

        $meta = $this->generalSettings->update(
            $surveyId,
            $input
        );

        if (!empty($input['url_params'])) {
            $this->urlParams->update(
                $surveyId,
                $input['url_params']
            );
        }

        $this->proxyExpressionManager
            ->reset($surveyId);

        $this->templateConfiguration
            ->update($surveyId);

        if (!empty($input['variant'] || !empty($input['variant_css']))) {
            $this->templateConfiguration->updateVariant(
                $surveyId,
                $input
            );
        }

        return $meta;
    }
}
