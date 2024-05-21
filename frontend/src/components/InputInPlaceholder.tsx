'use client';

import {Input} from "@nextui-org/react";

interface SelectSearchProps {
    name: string;
    type: string;
    value?: any;
    placeholder?: string;
    onChange?: (value: React.ChangeEvent<HTMLInputElement>) => void;
}

const InputInPlaceholder: React.FC<SelectSearchProps> = ({ name, type, value, placeholder, onChange }) => {
    return (
        <>
            <Input 
                id={name}
                name={name}
                isClearable 
                type={type} 
                label={placeholder} 
                value={value}
                onChange={onChange}
                classNames={{
                    label: "text-white dark:text-white",
                    input: [
                        "bg-zinc-800",
                        "placeholder:text-white dark:placeholder:text-white",
                    ],
                    innerWrapper: "bg-zinc-800",
                    inputWrapper: [
                        "rounded-none",
                        "shadow-xl",
                        "bg-default-200/50",
                        "dark:bg-zinc-800",
                        "backdrop-blur-xl",
                        "backdrop-saturate-200",
                        "hover:bg-zinc-800",
                        "dark:hover:bg-zinc-800",
                        "group-data-[focus=true]:bg-zinc-800",
                        "dark:group-data-[focus=true]:bg-zinc-800",
                        "!cursor-text",
                    ],
                }}
            />
        </>
    );
};

export default InputInPlaceholder;