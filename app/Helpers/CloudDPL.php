<?php

namespace App\Helpers;

use Google\Cloud\Dlp\V2\ContentItem;
use Google\Cloud\Dlp\V2\DlpServiceClient;
use Google\Cloud\Dlp\V2\InfoType;
use Google\Cloud\Dlp\V2\InspectConfig;
use Google\Cloud\Dlp\V2\InspectConfig\FindingLimits;
use Google\Cloud\Dlp\V2\Likelihood;

// Instantiate a client.
$dlp = new DlpServiceClient();

// The infoTypes of information to match
$usNameInfoType = (new InfoType())
    ->setName('PERSON_NAME');
$phoneNumberInfoType = (new InfoType())
    ->setName('PHONE_NUMBER');
$infoTypes = [$usNameInfoType, $phoneNumberInfoType];

// Set the string to inspect
$stringToInspect = 'Robert Frost';

// Only return results above a likelihood threshold, 0 for all
$minLikelihood = likelihood::LIKELIHOOD_UNSPECIFIED;

// Limit the number of findings, 0 for no limit
$maxFindings = 0;

// Whether to include the matching string in the response
$includeQuote = true;

// Specify finding limits
$limits = (new FindingLimits())
    ->setMaxFindingsPerRequest($maxFindings);

// Create the configuration object
$inspectConfig = (new InspectConfig())
    ->setMinLikelihood($minLikelihood)
    ->setLimits($limits)
    ->setInfoTypes($infoTypes)
    ->setIncludeQuote($includeQuote);

$content = (new ContentItem())
    ->setValue($stringToInspect);

$projectId = getenv('GCLOUD_PROJECT');
$parent = $dlp->projectName($projectId);

// Run request
$response = $dlp->inspectContent([
    'parent' => $parent,
    'inspectConfig' => $inspectConfig,
    'item' => $content
]);

// Print the results
$findings = $response->getResult()->getFindings();
if (count($findings) == 0) {
    print('No findings.' . PHP_EOL);
} else {
    print('Findings:' . PHP_EOL);
    foreach ($findings as $finding) {
        if ($includeQuote) {
            print('  Quote: ' . $finding->getQuote() . PHP_EOL);
        }
        print('  Info type: ' . $finding->getInfoType()->getName() . PHP_EOL);
        $likelihoodString = Likelihood::name($finding->getLikelihood());
        print('  Likelihood: ' . $likelihoodString . PHP_EOL);
    }
}
