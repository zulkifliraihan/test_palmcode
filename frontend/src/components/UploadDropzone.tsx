'use client'
import { useRef, useState } from 'react'


export default function UploadDropzone(props: any) {
    
    const hiddenInputRef = useRef<HTMLInputElement | null>(null)

    const [fileSize, setFileSize] = useState("")
    const [fileName, setFileName] = useState("")
    
    const handleClick = () => {
        if (hiddenInputRef.current) {
            hiddenInputRef.current.click()
          }
    }

    const dropHandler = (event: any) => {
        event.preventDefault()

        addFile(event, "drag&drop")
    }

    const addFile = (event: any, type?: string) => {

        const file = type == undefined ? event.target.files[0] : event.dataTransfer.files[0]

        const size: string  = file.size > 1024 
                        ? file.size > 1048576 
                            ? Math.round(file.size / 1048576) + "mb" 
                            : Math.round(file.size / 1024) + "kb"
                        : file.size + "b"
                        
        setFileSize(size)
        setFileName(file.name)
        props.onChange(file)

    }

    const deleteFile = () => {
        setFileSize("")
        setFileName("")
    }

    return (
        <>
            <div className={`overflow-auto w-full h-full flex flex-col text-sm text-white bg-zinc-800 mb-4 ${(fileName && fileSize) ? "hidden" : "visible"} `}
                onDrop={dropHandler}
            >
                <div className="py-8 flex flex-col justify-center items-center">
                    <p className="mb-3 font-semibold justify-center">
                    <span>Drag & Drop</span>
                    </p>
                    <p className="text-zinc-600 text-sm pb-4">or select files from device max. 2MB</p>
                    <input 
                        id="hidden-input" 
                        type="file" 
                        className="hidden"
                        ref={hiddenInputRef}
                        onChange={addFile}
                    />
                    <a className="underline" onClick={handleClick}>Upload</a>
                </div>
            </div>

            <div className={`w-full h-full bg-zinc-800 flex p-6 ${(!fileName && !fileSize) ? "hidden" : "visible"}`}>
                <div>
                    <svg id="SvgjsSvg1078" width="40" height="40" xmlns="http://www.w3.org/2000/svg" version="1.1"><defs id="SvgjsDefs1079"></defs><g id="SvgjsG1080"><svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 70 70" width="40" height="40"><path fill="none" stroke="#c7f900" strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M40.5 16.5v11h11" className="colorStroke000 svgStroke"></path><path fill="none" stroke="#c7f900" strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M38.76 15.5h-17a3.31 3.31 0 0 0-3.3 3.3v33.4a3.31 3.31 0 0 0 3.3 3.3h26.43a3.33 3.33 0 0 0 3.31-3.3V28.1a3.16 3.16 0 0 0-.9-2.3l-9.53-9.3a2.91 2.91 0 0 0-2.31-1z" className="colorStroke000 svgStroke"></path></svg></g></svg>
                </div>
                <div>
                    <h3 className="pl-4 text-white text-sm mb-1">{fileName}</h3>
                    <h3 className="pl-4 text-zinc-500 text-sm">{fileSize}</h3>
                </div>
                <button type="button" className="ml-auto place-content-center" onClick={deleteFile}>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="18" height="18"><rect width="18" height="18" fill="none"></rect><line x1="200" x2="56" y1="56" y2="200" stroke="#fc0000" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" className="colorStroke000 svgStroke"></line><line x1="200" x2="56" y1="200" y2="56" stroke="#fc0000" strokeLinecap="round" strokeLinejoin="round" strokeWidth="16" className="colorStroke000 svgStroke"></line></svg>
                </button>
            </div>
        </>
    )
}
