import { Button } from '@/components/ui/button';
import { SearchQueryProvider } from '@/contexts/search-query-context';
import SearchLayout from '@/layouts/search-layout';
import { Head, Link } from '@inertiajs/react';
import { UndoIcon } from 'lucide-react';

export default function NotFoundPage() {
    return (
        <SearchQueryProvider>
            <SearchLayout showSearchFilter={false}>
                <Head title="404 Not Found" />
                <main className="mx-auto flex min-h-[60vh] w-full max-w-3xl flex-1 flex-col items-center justify-center p-6">
                    <div className="flex flex-col items-center rounded-xl">
                        <h1 className="mb-4 text-6xl font-bold text-blue-900">404</h1>
                        <h2 className="mb-2 text-2xl font-semibold text-gray-800">Page Not Found</h2>
                        <p className="mb-6 max-w-md text-center text-gray-600">
                            Sorry, the page you are looking for does not exist or has been removed.
                        </p>
                        <Button variant="link" className="dark:text-secondary gap-1" asChild>
                            <Link href="/">
                                <UndoIcon size={16} />
                                Back to Feed
                            </Link>
                        </Button>
                    </div>
                </main>
            </SearchLayout>
        </SearchQueryProvider>
    );
}
