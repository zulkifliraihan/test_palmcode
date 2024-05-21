export const logErrorApi = (
    apiType: string, 
    url: string, 
    status: number, 
    message: string
) => {
    console.error(
`
    HTTP Error!
    API: ${apiType}
    URL: ${url}
    status: ${status}
    message: ${message}
`
    )
}