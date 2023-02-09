// @ts-ignore
import Cookies from 'js-cookie'

// @ts-ignore
export default defineNuxtRouteMiddleware(( to, from ) => {
    if (Cookies.get('access_token')) {
        abortNavigation()
        return navigateTo('/')
    }
})