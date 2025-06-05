import { createContext, useContext } from 'react';

interface SearchQueryContextProps {
    searchQuery?: string;
    setSearchQuery: (value: string) => void;
}

export const SearchQueryContext = createContext<SearchQueryContextProps | undefined>(undefined);

interface SearchQueryProviderProps extends SearchQueryContextProps {
    children: React.ReactNode;
}

export function SearchQueryProvider({ children, searchQuery = '', setSearchQuery = () => {} }: Partial<SearchQueryProviderProps>) {
    return <SearchQueryContext value={{ searchQuery, setSearchQuery }}>{children}</SearchQueryContext>;
}

export function useSearchQueryContext() {
    const context = useContext(SearchQueryContext);

    if (!context) {
        throw new Error('useSearchQueryContext must be used within a SearchQueryProvider');
    }

    return context;
}
