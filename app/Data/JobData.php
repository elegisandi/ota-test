<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;
use App\Enums\EmploymentType;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

class JobData extends Data
{
    #[Computed]
    public string $descriptionPreview;
    public string $employmentTypeLabel;

    public function __construct(
        public string $uuid,
        public string $title,
        public string $description,
        public ?string $location,

        #[MapInputName('employment_type')]
        public EmploymentType $employmentType,

        public ?string $companyName,

        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        #[MapInputName('created_at')]
        public ?CarbonImmutable $datePosted,
    ) {
        $this->descriptionPreview = mb_strimwidth(strip_tags($this->description), 0, 500, '...');
        $this->employmentTypeLabel = $this->employmentType->getLabel();
    }
}
