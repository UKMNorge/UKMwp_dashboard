<?php

use UKMNorge\Nettverk\Omrade;
use UKMNorge\UKMWebinar\TeamsUKMWebinarer;

global $current_user;

$TWIGdata['blogs'] = get_blogs_of_user($current_user->ID);
$TWIGdata['kurskommune'] = Omrade::getByKommune(UKM_HOSTNAME == 'ukm.dev' ? 5441 : 9291);

$teamsWebinarer = new TeamsUKMWebinarer();
$aktiveTeamsWebinarer = [];
$alleTeamsWebinarer = [];

if (is_callable([$teamsWebinarer, 'getAlleAcive'])) {
    $aktiveTeamsWebinarer = call_user_func([$teamsWebinarer, 'getAlleAcive']);
} elseif (is_callable([$teamsWebinarer, 'getAlleActive'])) {
    $aktiveTeamsWebinarer = call_user_func([$teamsWebinarer, 'getAlleActive']);
}

if (is_callable([$teamsWebinarer, 'getAll'])) {
    $alleTeamsWebinarer = call_user_func([$teamsWebinarer, 'getAll']);
} elseif (is_callable([$teamsWebinarer, 'getAlle'])) {
    $alleTeamsWebinarer = call_user_func([$teamsWebinarer, 'getAlle']);
}

if (empty($alleTeamsWebinarer)) {
    $alleTeamsWebinarer = $aktiveTeamsWebinarer;
}

$TWIGdata['teamsWebinarer'] = $aktiveTeamsWebinarer;

$webinarOpptakPrefix = 'webinar_opptak';
$webinarOpptakPrefixes = ['webinar_opptak', 'opptak_webinar'];
$webinarOpptak = [];

$attachments = get_posts([
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
]);

foreach ($attachments as $attachment) {
    $attachedFileMeta = (string) get_post_meta($attachment->ID, '_wp_attached_file', true);
    $filePath = get_attached_file($attachment->ID, true);
    $candidateName = $attachedFileMeta ?: ($filePath ?: '');
    $fileName = basename((string) $candidateName);

    if (!$fileName) {
        $fileName = basename((string) wp_get_attachment_url($attachment->ID));
    }

    if (!$fileName) {
        continue;
    }

    $filenameLower = mb_strtolower($fileName);
    $hasValidPrefix = false;
    foreach ($webinarOpptakPrefixes as $prefix) {
        if (strpos($filenameLower, $prefix) === 0) {
            $hasValidPrefix = true;
            break;
        }
    }

    if (!$hasValidPrefix) {
        continue;
    }

    $webinarOpptak[] = [
        'id' => $attachment->ID,
        'title' => get_the_title($attachment->ID),
        'filename' => $fileName,
        'url' => wp_get_attachment_url($attachment->ID),
        'mime' => get_post_mime_type($attachment->ID),
        'date' => get_the_date('d.m.Y H:i', $attachment->ID),
    ];
}

$TWIGdata['webinarOpptak'] = $webinarOpptak;
$TWIGdata['webinarOpptakPrefix'] = $webinarOpptakPrefix;
$TWIGdata['webinarOpptakPrefixes'] = $webinarOpptakPrefixes;

$normalizeText = function (string $text): string {
    $normalized = mb_strtolower($text);
    $normalized = preg_replace('/[^a-z0-9]+/u', '', $normalized);
    return $normalized ?? '';
};

$ekskluderteWebinarNavn = [
    'nettseminartest',
    'nettseminar'
];

$webinarHistorikkOpptak = [];
$seenWebinarKeys = [];
$brukteOpptakIds = [];
$minimumMatchScore = 2;
foreach ($alleTeamsWebinarer as $webinar) {
    if (!method_exists($webinar, 'erFerdig') || !$webinar->erFerdig()) {
        continue;
    }

    $webinarNavn = method_exists($webinar, 'getNavn') ? (string) $webinar->getNavn() : '';
    $webinarNavnNorm = $normalizeText($webinarNavn);
    if (in_array($webinarNavnNorm, $ekskluderteWebinarNavn, true)) {
        continue;
    }

    $webinarStart = method_exists($webinar, 'getStart') ? $webinar->getStart() : null;
    $webinarDato = $webinarStart instanceof DateTimeInterface ? $webinarStart->format('d.m.Y H:i') : null;
    $webinarDatoYmd = $webinarStart instanceof DateTimeInterface ? $webinarStart->format('Ymd') : null;
    $webinarDatoYm = $webinarStart instanceof DateTimeInterface ? $webinarStart->format('Ym') : null;
    $webinarTimestamp = $webinarStart instanceof DateTimeInterface ? $webinarStart->getTimestamp() : 0;
    $webinarUrl = method_exists($webinar, 'getURL') ? $webinar->getURL() : null;

    $dedupeKey = 'name:' . $webinarNavnNorm . '|t:' . $webinarTimestamp;
    if ($webinarNavnNorm === '' && $webinarTimestamp === 0) {
        $dedupeKey = 'url:' . ($webinarUrl ?: 'unknown');
    }

    if (isset($seenWebinarKeys[$dedupeKey])) {
        continue;
    }
    $seenWebinarKeys[$dedupeKey] = true;

    $bestMatch = null;
    $bestScore = 0;

    foreach ($webinarOpptak as $fil) {
        if (isset($brukteOpptakIds[$fil['id']])) {
            continue;
        }

        $filenameNorm = $normalizeText($fil['filename']);
        $titleNorm = $normalizeText((string) $fil['title']);
        $score = 0;
        $hasNameMatch = false;
        $hasExactDateMatch = false;

        if (strlen($webinarNavnNorm) > 4) {
            if (strpos($filenameNorm, $webinarNavnNorm) !== false) {
                $score += 3;
                $hasNameMatch = true;
            }
            if (strpos($titleNorm, $webinarNavnNorm) !== false) {
                $score += 2;
                $hasNameMatch = true;
            }
        }

        if ($webinarDatoYmd && strpos($fil['filename'], $webinarDatoYmd) !== false) {
            $score += 2;
            $hasExactDateMatch = true;
        } elseif ($webinarDatoYm && strpos($fil['filename'], $webinarDatoYm) !== false) {
            $score += 1;
        }

        if (!$hasNameMatch && !$hasExactDateMatch) {
            continue;
        }

        if ($score > $bestScore) {
            $bestScore = $score;
            $bestMatch = $fil;
        }
    }

    if ($bestMatch && $bestScore >= $minimumMatchScore) {
        $brukteOpptakIds[$bestMatch['id']] = true;
    } else {
        $bestMatch = null;
    }

    $webinarHistorikkOpptak[] = [
        'title' => $webinarNavn,
        'date' => $webinarDato,
        'timestamp' => $webinarTimestamp,
        'webinarUrl' => $webinarUrl,
        'opptak' => $bestMatch,
    ];
}

usort($webinarHistorikkOpptak, function (array $a, array $b) {
    return ($b['timestamp'] ?? 0) <=> ($a['timestamp'] ?? 0);
});

$TWIGdata['webinarHistorikkOpptak'] = $webinarHistorikkOpptak;

require_once(UKMwp_innhold::getPath() . 'functions/getCategory.function.php');

$category_ids = [];

// Ta ut markedsføringsfilmer
$categories = [
    'markedsforing-filmer' => '-',
    'alle-nyhetsbrev' => '-'
];

foreach( $categories as $category_slug => $action ) {
    $category_data = getCategory($category_slug);
    if( $category_data ) {
        $category_ids[] = $action . $category_data->term_id;
    }
}

/* NEWS */
$POST_QUERY = 'cat=' . implode(',', $category_ids);
require_once(UKMwp_innhold::getPluginPath() . 'controller/news.controller.php');

require_once('profil.controller.php');
