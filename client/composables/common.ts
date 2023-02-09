// @ts-ignore
import Cookies from "js-cookie"

export default function generateHeader() {
    let token = Cookies.get('access_token')
    return {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }
}