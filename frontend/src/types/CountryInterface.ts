export interface CountryAllTypes {
    id: number
    name: string
    capital: string
    iso2: string
    iso3: string
    phone_code: string
    currency: string
    flag: string
    created_at: string
    updated_at: string
}

export interface CountrySelectSearchTypes {
    value: number
    label: string
    phoneCode: string
}