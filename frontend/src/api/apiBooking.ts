import apiUrl from "@/data/global";
import { ReturnData } from "@/types/RetunInterface";

const createBooking = async (data: FormData) => {
    let returnData: ReturnData = {
        status: false,
        data: {}
    }

    try {
        const url = `${apiUrl}/api/public/bookings/create`
    
        const res = await fetch(url, {
            method: "POST",
            body: data,
        })
        
        returnData = {
            status: true,
            data: await res.json()
        }
        return returnData        
    } catch (error) {
        returnData = {
            status: false,
            data: error
        }
        return returnData
    }
}

export {
    createBooking
}