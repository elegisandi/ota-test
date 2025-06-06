import { Button } from '@/components/ui/button';
import { SearchQueryProvider } from '@/contexts/search-query-context';
import SearchLayout from '@/layouts/search-layout';
import { JobDetailsProps } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Building2Icon, HandshakeIcon, HistoryIcon, MapPinIcon, UndoIcon } from 'lucide-react';

export default function JobDetailsPage({ job }: JobDetailsProps) {
    return (
        <SearchQueryProvider>
            <SearchLayout showSearchFilter={false}>
                <Head title={job.title} />
                <main className="mx-auto w-full max-w-3xl flex-1 p-6">
                    <div className="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                        <div className="mb-6 flex items-start justify-between gap-6">
                            <h1 className="text-3xl font-semibold text-blue-900">{job.title}</h1>
                            <Button variant="link" className="dark:text-secondary gap-1" asChild>
                                <Link href="/">
                                    <UndoIcon size={16} />
                                    Back to Feed
                                </Link>
                            </Button>
                        </div>

                        <div className="space-y-6">
                            <section className="mb-6 space-y-2">
                                <div className="flex items-center gap-1">
                                    <Building2Icon size={16} /> Company:
                                    <span className="text-lg font-medium text-gray-800">{job.companyName}</span>
                                </div>
                                <div className="flex items-center gap-1 text-gray-600">
                                    <MapPinIcon size={16} /> Location:
                                    <span className="text-md">{job.location}</span>
                                </div>
                                <div className="flex items-center gap-1 text-gray-600">
                                    <HandshakeIcon size={16} />
                                    Employment Type:
                                    <span className="text-md">{job.employmentTypeLabel}</span>
                                </div>
                                <div className="flex items-center gap-1 text-gray-500">
                                    <HistoryIcon size={16} />
                                    Date Posted:
                                    <span className="text-md">{job.datePosted}</span>
                                </div>
                            </section>

                            <section>
                                <h2 className="dark:text-secondary mb-4 border-b border-gray-100 pb-1 text-xl font-medium">Job Details</h2>
                                <div className="text-gray-700" dangerouslySetInnerHTML={{ __html: job.description }} />
                            </section>
                        </div>
                    </div>
                </main>
            </SearchLayout>
        </SearchQueryProvider>
    );
}
