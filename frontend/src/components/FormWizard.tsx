'use client'

import {Button, Select, SelectItem, Slider} from "@nextui-org/react"
import { useEffect, useState } from 'react'
import SelectSearch from "@/components/SelectSearch"
import InputInPlaceholder from "@/components/InputInPlaceholder"
import UploadDropzone from "@/components/UploadDropzone"
import { getCountryList } from "@/api/apiCountry"
import { createBooking } from "@/api/apiBooking"
import { CountrySelectSearchTypes } from "@/types/CountryInterface"

import Swal from 'sweetalert2'
import { ReturnData } from "@/types/RetunInterface"

export default function FormWizard() {
    const [currentPage, setCurrentPage] = useState(1)
    const [countries, setCountries] = useState([])
    const [loadingSubmit, setLoadingSubmit] = useState(false)

    const [nameValue, setNameValue] = useState('')
    const [countryValue, setCountryValue] = useState<CountrySelectSearchTypes>({
        value: 0,
        label: '',
        phoneCode: ''
    })
    const [emailValue, setEmailValue] = useState('')
    const [whatsappNumberValue, setWhatsappNumberValue] = useState('')
    const [surfingExperienceValue, setSurfingExperienceValue] = useState(0)
    const [visitDateValue, setvisitDateValue] = useState('')
    const [desiredBoardValue, setDesiredBoardValue] = useState('')
    const [identificationIdValue, setIdentificationIdValue] = useState(null)
    const [countdown, setCountdown] = useState(10)

    useEffect(() => {
        getCountries()
    }, [])
    
    const autoRefresh = () => {
        const timer = setInterval(() => {
            setCountdown((prevCountdown) => {
                if (prevCountdown <= 1) {
                    clearInterval(timer)
                    window.location.reload()
                    return 0
                }
                return prevCountdown - 1
            })
        }, 1000)    
    }

    const desiredBoards = [
        { label: "Longboard", value: "Longboard"},
        { label: "Funboard", value: "Funboard"},
        { label: "Shortboard", value: "Shortboard"},
        { label: "Fishboard", value: "Fishboard"},
        { label: "Gunboard", value: "Gunboard"},
    ]

    const getCountries = async () => {
        const data = await getCountryList()
        const countries = data.map((item: any) => ({
            value: item.id,
            label: `${item.flag} ${item.name}`,
            phoneCode: item.phone_code
        }))
        setCountries(countries)
    }


    const handleChangeCountry = (id: string) => {
        const selectedCountryDetails: any = countries.find((country: any) => country.value == id)
        setCountryValue(selectedCountryDetails)
        setWhatsappNumberValue(selectedCountryDetails.phoneCode)
    }
    
    const changePage = () => {
        setCurrentPage(currentPage + 1)
    }

    const handleFileAdded = (file: any) => {
        setIdentificationIdValue(file)
    }

    const handleSubmit = async (event: any) => {
        setLoadingSubmit(true)

        event.preventDefault()
        const formData = new FormData()
        formData.append('country_id', countryValue.value.toString())
        formData.append('name', nameValue)
        formData.append('email', emailValue)
        formData.append('whatsapp_number', whatsappNumberValue)
        formData.append('surfing_experience', surfingExperienceValue.toString())
        formData.append('visit_date', visitDateValue)
        formData.append('desired_board', desiredBoardValue)
        if (identificationIdValue) {
            formData.append('identification_id', identificationIdValue)
        }

        const result: ReturnData = await createBooking(formData)

        if(result.status) {

            if(result.data.response_code == 422) {
                const errorMessage = Object.keys(result.data.errors).map((key) => {
                    const formattedKey = key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())
                    return `
                    <p class="text-sm">${formattedKey}: ${result.data.errors[key].join(', ')}</p>`
                }).join('<br>')
    
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessage,
                }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.reload();
                    }
                })
            }
            else {
                changePage()
                autoRefresh()
            }
        }
        else {
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: "Something wrong! Contact administrator!",
            }).then((result) => {
                if (result.isConfirmed) {
                  window.location.reload();
                }
            })
            autoRefresh()
        }
        
    }

    return (
        <>
            <div className={currentPage != 4 ? 'visible' : 'hidden'}>
                <h4 className="mb-4 block font-bodoni-moda text-5xl leading-snug tracking-normal text-white antialiased">
                Book Your Visit
                </h4>
    
                <h4 className="my-4 block font-inter text-xl leading-snug tracking-normal text-white antialiased">
                    {
                        currentPage === 1 ? `1/3 : VISITOR DETAILS` :
                        currentPage === 2 ? `2/3 : SURFING EXPERIENCE` :
                        currentPage === 3 ? `3/3 : ID VERIFICATION` :
                        ""
                    }

                </h4>
                
                <div className="mt-10">
                    <form onSubmit={handleSubmit}>

                        <div className={`grid grid-cols-2 gap-8 mb-12 ${currentPage != 1 ? "hidden" : "visible"}`}>
                            <div>
                                <InputInPlaceholder type="text" name="name" placeholder="Name" value={nameValue} onChange={(e: any) => setNameValue(e.target.value)}/>
                            </div>
                            <div>
                                <SelectSearch placeholder="Country" items={countries} value={emailValue} onChange={handleChangeCountry} />
                            </div>
                            <div>
                                <InputInPlaceholder type="email" name="email" placeholder="Email" value={emailValue} onChange={(e: any) => setEmailValue(e.target.value)}/>
                            </div>
                            <div>
                                <InputInPlaceholder type="text" name="whatsapp_number" placeholder="Whatsapp number" value={whatsappNumberValue} onChange={(e: any) => setWhatsappNumberValue(e.target.value)}/>
                            </div>
                        </div>
                        <div className={`grid grid-cols-2 gap-8 mb-6 ${currentPage != 2 ? "hidden" : "visible"}`}>
                            <div className="col-span-2">
                                <Slider   
                                    step={1}
                                    color="foreground"
                                    label="Your Sufing Experience"
                                    showSteps={true} 
                                    maxValue={10} 
                                    minValue={0} 
                                    defaultValue={0}
                                    className="w-full"
                                    marks={[
                                        {
                                        value: 0,
                                        label: "0",
                                        },
                                        {
                                        value: 1,
                                        label: "1",
                                        },
                                        {
                                        value: 2,
                                        label: "2",
                                        },
                                        {
                                        value: 3,
                                        label: "3",
                                        },
                                        {
                                        value: 4,
                                        label: "4",
                                        },
                                        {
                                        value: 5,
                                        label: "5",
                                        },
                                        {
                                        value: 6,
                                        label: "6",
                                        },
                                        {
                                        value: 7,
                                        label: "7",
                                        },
                                        {
                                        value: 8,
                                        label: "8",
                                        },
                                        {
                                        value: 9,
                                        label: "9",
                                        },
                                        {
                                        value: 10,
                                        label: "10",
                                        }
                                    ]}
                                    classNames={{
                                        base: "gap-3",
                                        track: "border-s-secondary-100",
                                        filler: "bg-gradient-to-r from-white to-sky-500"
                                    }}
                                    renderThumb={(props) => (
                                        <div
                                        {...props}
                                        className="group p-1 top-1/2 bg-background border-small border-default-200 dark:border-default-400/50 shadow-medium rounded-full cursor-grab data-[dragging=true]:cursor-grabbing"
                                        >
                                        <span className="transition-transform bg-gradient-to-br shadow-small from-white to-sky-500 rounded-full w-5 h-5 block group-data-[dragging=true]:scale-80" />
                                        </div>
                                    )}
                                    value={surfingExperienceValue} 
                                    onChange={(e: any) => setSurfingExperienceValue(e)}
                                />
                            </div>
                            <div>
                                <InputInPlaceholder type="date" name="visit_date" placeholder="Visit date" value={visitDateValue} onChange={(e: any) => setvisitDateValue(e.target.value)} />
                            </div>
                            <div>
                                <Select 
                                    label="Your desired board" 
                                    classNames={{
                                    base: ["bg-zinc-800", "hover:bg-zinc-800"],
                                    listbox: ["bg-zinc-800", "hover:bg-zinc-800"],
                                    listboxWrapper: ["bg-zinc-800", "hover:bg-zinc-800"],
                                    helperWrapper: ["bg-zinc-800", "hover:bg-zinc-800"],
                                    trigger: ["bg-zinc-800", "hover:bg-zinc-800"],
                                    popoverContent: ["bg-zinc-800", "hover:bg-zinc-800"],
                                    mainWrapper: [
                                        "bg-zinc-800",
                                        "hover:bg-zinc-800",
                                    ],
                                    innerWrapper: [
                                        "bg-zinc-800",
                                        "hover:bg-zinc-800",
                                    ]
                                    }}
                                    value={desiredBoardValue} 
                                    onChange={(e: any) => setDesiredBoardValue(e.target.value)}
                                >
                                    {desiredBoards.map((board) => (
                                        <SelectItem key={board.value} value={board.value}>
                                            {board.label}
                                        </SelectItem>
                                    ))}
                                </Select>
                            </div>
                        </div>
                        <div className={`grid grid-cols-2 gap-8 ${currentPage != 3 ? "hidden" : "visible"}`}>
                            <div className="col-span-2 mb-4">
                                <p className="text-white mb-8 font-inter text-lg">
                                    Help us verify your identity by uploading a photo of your ID/KTP or Passport
                                </p>
                                <div className="">
                                    <UploadDropzone onChange={handleFileAdded} />
                                </div>
                            </div>
                        </div>
                        <div className="w-36 mt-4">
                            <Button 
                                radius="none" 
                                type={currentPage == 3 ? 'submit' : 'button'}
                                fullWidth={true} 
                                disabled={currentPage == 3 && identificationIdValue == null}
                                className={`font-inter font-semibold ${(currentPage == 3 && identificationIdValue == null) ? "bg-gray-500" : "bg-white"}`}
                                onClick={currentPage == 3 ? handleSubmit : changePage}
                                isLoading={loadingSubmit}
                                spinner={
                                    <svg
                                      className="animate-spin h-5 w-5 text-current"
                                      fill="none"
                                      viewBox="0 0 24 24"
                                      xmlns="http://www.w3.org/2000/svg"
                                    >
                                      <circle
                                        className="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        strokeWidth="4"
                                      />
                                      <path
                                        className="opacity-75"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        fill="currentColor"
                                      />
                                    </svg>
                                  }
                            >
                                
                                {
                                    currentPage == 3 ? "Book My Visit" : "Next"
                                }
                            </Button>  
                        </div>
                    </form>
                </div>
            </div>
            <div>
            <div className={`w-4/5 ${currentPage == 4 ? 'visible' : 'hidden'}`}>
                <h4 className="mb-4 block font-bodoni-moda text-4xl leading-snug tracking-normal text-white antialiased">
                    Thank you, {nameValue}
                </h4>
                <div className="text-white font-inter text-md">
                    <div className="mb-12">
                        <p>You&apos;re in</p>
                        <p>Your store visit is booked and you&apos; ready to ride the shopping wave. Here&aposs your detail:</p>
                    </div>
                    <div className="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <label className="text-zinc-500">Name: </label>
                            <h1>{nameValue}</h1>
                        </div>
                        <div>
                            <label className="text-zinc-500">Country: </label>
                            <h1>{countryValue.label}</h1>
                        </div>
                        <div>
                            <label className="text-zinc-500">Email: </label>
                            <h1>{emailValue}</h1>
                        </div>
                        <div>
                            <label className="text-zinc-500">Visit Date: </label>
                            <h1>{visitDateValue}</h1>
                        </div>
                    </div>
                    <div className="mb-8">
                        <p>We look forward to seeing you at the #Sweellmatch store! Your booking details already send to your email and whatsapp</p>
                    </div>
                    <div className="text-zinc-500">
                        <p>This form will be refresh automatically in {countdown} seconds</p>
                    </div>
                </div>
                </div>
            </div>
        </>
    )
}