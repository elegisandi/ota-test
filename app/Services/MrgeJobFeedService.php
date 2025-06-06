<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Enums\EmploymentType;
use Illuminate\Support\Carbon;
use Saloon\XmlWrangler\XmlReader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

use App\Contracts\ExternalJobFeedInterface;

final class MrgeJobFeedService implements ExternalJobFeedInterface
{
    public const XML_URL = 'https://mrge-group-gmbh.jobs.personio.de/xml';
    public const UUID_PREFIX = 'mrge-';

    public function get(): Collection
    {
        $result = $this->fetch();

        if ($result->isEmpty()) {
            return collect([]);
        }

        return $result->map(function (array $item) {
            $description = $item['jobDescriptions']['jobDescription'] ?? 'NA';

            if (is_array($description)) {
                $description = array_reduce($description, function ($carry, $desc) {

                    $html = <<<HTML
                    <h3 class="text-xl mb-2">{$desc['name']}</h3>
                    {$desc['value']}
                    HTML;

                    return $carry . $html;
                }, '');
            }

            $temp_employmentType = Str::of($item['schedule'] ?? 'NA')
                ->lower()
                ->replace([' ', '-'], '')
                ->toString();

            $employmentType = match ($temp_employmentType) {
                'fulltime', => EmploymentType::FULL_TIME,
                'parttime' => EmploymentType::PART_TIME,
                'contract' => EmploymentType::CONTRACT,
                'temporary' => EmploymentType::TEMPORARY,
                'intern', 'internship' => EmploymentType::INTERN,
                'volunteer' => EmploymentType::VOLUNTEER,
                default => EmploymentType::UNKNOWN,
            };

            return [
                'uuid' => self::UUID_PREFIX . $item['id'],
                'title' => $item['name'],
                'description' => $description,
                'location' => $item['office'] ?? 'NA',
                'employmentType' => $employmentType,
                'companyName' => $item['subcompany'] ?? 'NA',
                'created_at' => $item['createdAt'] ? Carbon::parse($item['createdAt']) : null,
            ];
        });
    }

    private function fetch(): Collection
    {
        try {
            $response = Http::timeout(10)
                ->get(self::XML_URL)
                ->throw()
                ->toPsrResponse();

            $reader = XmlReader::fromPsrResponse($response);

            return $reader->value('workzag-jobs.position')->collect();
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            logger('Failed to fetch or parse XML feed from MRGE', [
                'error' => $e->getMessage(),
            ]);
        }

        return collect([]);
    }
}
