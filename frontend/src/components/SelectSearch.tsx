'use client';
import { useEffect, useRef, useState } from 'react';

interface Option {
  value: string;
  label: string;
}

interface SelectSearchProps {
  items: Option[];
  value?: string;
  placeholder?: string;
  onChange?: (value: string) => void;
}

const SelectSearch: React.FC<SelectSearchProps> = ({ items, value, placeholder, onChange }) => {
  const [isOpen, setIsOpen] = useState(false);
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedValue, setSelectedValue] = useState(value || '');
  const [selectedLabel, setSelectedLabel] = useState(placeholder ?? 'Chosee');
  const dropdownGroupRef = useRef<HTMLDivElement>(null);

  const filteredItems = items
    .slice(1)
    .filter((item) => item.label.toLowerCase().includes(searchTerm.toLowerCase()));

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  const selectedData = (data: Option) => {
    setSelectedLabel(data.label);
    setSelectedValue(data.value);
    setIsOpen(false);
    onChange?.(data.value);
  };

  const handleClickOutside = (event: MouseEvent) => {
    if (dropdownGroupRef.current && !dropdownGroupRef.current.contains(event.target as Node)) {
      setIsOpen(false);
    }
  };

  useEffect(() => {
    document.addEventListener('click', handleClickOutside);
    return () => {
      document.removeEventListener('click', handleClickOutside);
    };
  }, []);

  return (
    <div className="flex h-full rounded-none">
      <div ref={dropdownGroupRef} className="relative group w-full">
        <button
          type="button"
          className="inline-flex h-full w-full px-4 py-2 text-sm rounded-none font-medium bg-zinc-800 border border-black shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-zinc-500 focus:ring-zinc-500 dark:text-white place-items-center"
          onClick={toggleDropdown}
        >
          <span className="mr-2 text-gray-400">{selectedLabel}</span>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="w-5 h-5 mr-2.5 mt-4 absolute inset-y-0 right-0"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
          >
            <path
              fillRule="evenodd"
              d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
              clipRule="evenodd"
            />
          </svg>
        </button>
        {isOpen && (
          <div className="absolute z-40 right-0 w-full mt-3 max-h-72 overflow-y-auto rounded-md shadow-lg bg-zinc-800 ring-1 ring-black ring-opacity-5 space-y-1 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-700 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <div className="sticky top-0 bg-zinc-800 p-2.5 dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <input
                value={searchTerm}
                onChange={(e) => setSearchTerm(e.target.value)}
                className="bg-zinc-50 h-10 pl-2 border border-zinc-300 text-gray-400 text-sm rounded-none focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-zinc-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                type="text"
                placeholder="Search items"
                autoComplete="off"
              />
            </div>
            {filteredItems.map((item) => (
              <a
                key={item.value}
                className="block px-4 py-2 text-zinc-700 hover-bg-zinc-100 active-bg-blue-100 bg-zinc-800 cursor-pointer rounded-md dark:bg-zinc-800 dark:border-zinc-700 dark:placeholder-zinc-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                onClick={() => selectedData(item)}
              >
                {item.label}
              </a>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

export default SelectSearch;