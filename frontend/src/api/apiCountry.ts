import apiUrl from "@/data/global"
import { logErrorApi } from "@/utils/logger"

const getCountryList = async () => {
    try {
        const url = `${apiUrl}/api/public/countries`
    
        const res = await fetch(url, {
            method: "GET",
        })

        if(!res.ok) {
            logErrorApi("Get Country List", res.url, res.status, res.statusText)
        }

        const result = await res.json()
    
        return result.data
        
    } catch (error) {
        console.error(error)
    }
}

export {
    getCountryList
}