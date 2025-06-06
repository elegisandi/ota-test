import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useSearchQueryContext } from '@/contexts/search-query-context';
import { SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';

interface SearchLayoutProps {
    children: React.ReactNode;
    showSearchFilter?: boolean;
}

export default function SearchLayout({ children, showSearchFilter = true }: SearchLayoutProps) {
    const { searchQuery, setSearchQuery } = useSearchQueryContext();
    const {
        name: appName,
        auth: { user },
    } = usePage<SharedData>().props;

    return (
        <div className="flex min-h-screen flex-col bg-gray-100">
            <header className="w-full bg-white shadow-sm">
                <div className="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-4 border-b border-gray-100 px-6 py-6 sm:flex-nowrap">
                    <span className="text-xl font-bold whitespace-nowrap text-gray-700">{appName}</span>
                    {showSearchFilter && (
                        <Input
                            type="text"
                            placeholder="Filter jobs..."
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            className="dark:text-secondary dark:selection:bg-secondary dark:selection:text-secondary-foreground border-gray-300 py-4 sm:w-100"
                        />
                    )}
                    <nav className="flex items-center whitespace-nowrap">
                        {!user ? (
                            <>
                                <Button variant="link" className="dark:text-secondary" asChild>
                                    <Link href="/login">Login</Link>
                                </Button>
                                <Button variant="outline" asChild>
                                    <Link href="/register">Register</Link>
                                </Button>
                            </>
                        ) : (
                            <Button variant="outline" asChild>
                                <Link href="/dashboard">Dashboard</Link>
                            </Button>
                        )}
                    </nav>
                </div>
            </header>
            {children}
            <footer className="mt-10 w-full border-t border-gray-100 bg-white py-4">
                <div className="mx-auto max-w-5xl px-6 text-center text-sm text-gray-400">
                    &copy; {new Date().getFullYear()} {appName}. All rights reserved.
                </div>
            </footer>
        </div>
    );
}
