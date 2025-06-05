import { SearchQueryProvider } from '@/contexts/search-query-context';
import SearchLayout from '@/layouts/search-layout';
import { JobFeedProps } from '@/types';
import { Deferred, Head, Link } from '@inertiajs/react';
import { HistoryIcon } from 'lucide-react';
import { useState } from 'react';

export default function JobFeedPage({ jobs = [] }: JobFeedProps) {
    const [searchQuery, setSearchQuery] = useState('');

    const filteredJobPosts = jobs.filter(
        (jobPost) =>
            jobPost.title.toLowerCase().includes(searchQuery.toLowerCase()) || jobPost.description.toLowerCase().includes(searchQuery.toLowerCase()),
    );

    const JobsPlaceholder = (props: React.HTMLAttributes<HTMLDivElement>) => (
        <div {...props}>
            {Array.from({ length: 5 }).map(() => (
                <div className="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm" key={Math.random()}>
                    <div className="h-6 w-3/4 animate-pulse rounded bg-gray-200"></div>
                    <div className="h-6 w-full animate-pulse rounded bg-gray-200"></div>
                    <div className="h-4 w-1/3 animate-pulse rounded bg-gray-200"></div>
                </div>
            ))}
        </div>
    );

    return (
        <SearchQueryProvider {...{ searchQuery, setSearchQuery }}>
            <SearchLayout>
                <Head title="Feed" />
                <main className="mx-auto w-full max-w-4xl flex-1 p-6">
                    <section>
                        <Deferred data="jobs" fallback={<JobsPlaceholder className="space-y-6" />}>
                            {filteredJobPosts.length === 0 ? (
                                <p className="text-center text-gray-500">No job posts found.</p>
                            ) : (
                                <ul className="space-y-6">
                                    {filteredJobPosts.map((jobPost) => (
                                        <li
                                            key={jobPost.uuid}
                                            className="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg hover:ring-2 hover:ring-blue-500"
                                        >
                                            <Link href={route('job.show', { uuid: jobPost.uuid })} className="block">
                                                <h2 className="mb-2 text-xl font-semibold text-blue-900 hover:underline">{jobPost.title}</h2>
                                            </Link>
                                            <p
                                                className="mb-3 line-clamp-3 text-gray-700"
                                                dangerouslySetInnerHTML={{ __html: jobPost.descriptionPreview }}
                                            />
                                            <div className="flex items-center gap-1 text-sm text-gray-400">
                                                <HistoryIcon size={16} /> {jobPost.datePosted}
                                            </div>
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </Deferred>
                    </section>
                </main>
            </SearchLayout>
        </SearchQueryProvider>
    );
}
