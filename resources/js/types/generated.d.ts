declare namespace App.Data {
export type JobData = {
descriptionPreview: string;
employmentTypeLabel: string;
uuid: string;
title: string;
description: string;
location: string | null;
companyName: string | null;
datePosted: string | null;
};
}
declare namespace App.Enums {
export type EmploymentType = 1 | 2 | 3 | 4 | 5 | 6 | 7;
export type JobPostStatus = 0 | 1 | 2;
export type UserRole = 1 | 2 | 3;
}
